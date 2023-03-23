<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Tag;

class CueOutTag extends AbstractTag
{
    private $cueout;

    const TAG_IDENTIFIER = '#EXT-X-CUE-OUT';

    public function setCueOut($cueout)
    {
        $this->cueout = $cueout;

        return $this;
    }

    public function isCueOut()
    {
        return $this->cueout;
    }

    public function dump()
    {
        if ($this->cueout) {
            return sprintf('%s:%.3f', self::TAG_IDENTIFIER, $this->cueout);
        }
    }

    protected function read($line)
    {
        $this->cueout = self::extractValue($line);
    }
}
