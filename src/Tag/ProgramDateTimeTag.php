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

class ProgramDateTimeTag extends AbstractTag
{
    use SingleValueTagTrait;

    private $programdatetime;

    const TAG_IDENTIFIER = '#EXT-X-PROGRAM-DATE-TIME';

    public function setProgramDateTime($programdatetime)
    {
        $this->programdatetime = new \DateTime($programdatetime);

        return $this;
    }

    public function getProgramDateTime()
    {
        return $this->programdatetime;
    }

    public function dump()
    {
        if (empty($this->programdatetime)) {
            return;
        }

        $time_zone = $this->programdatetime->format('P');
        $dump_date = sprintf('%s%s', substr($this->programdatetime->format('Y-m-d\TH:i:s.u'), 0, -3), $time_zone);
        return sprintf('%s:%s', self::TAG_IDENTIFIER,  $dump_date);
    }

    protected function read($line)
    {
        $this->programdatetime = new \DateTime(self::extractValue($line));
    }
}
