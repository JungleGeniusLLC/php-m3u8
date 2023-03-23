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

class CueInTag extends AbstractTag
{
    private $cuein = false;

    const TAG_IDENTIFIER = '#EXT-X-CUE-IN';

    public function setCueIn($cuein)
    {
        $this->cuein = $cuein;

        return $this;
    }

    public function isCueIn()
    {
        return $this->cuein;
    }

    public function dump()
    {
        if ($this->cuein) {
            return self::TAG_IDENTIFIER;
        }
    }

    protected function read($line)
    {
        $this->cuein = true;
    }
}
