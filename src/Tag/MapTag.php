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

class MapTag extends AbstractTag
{
    use AttributesValueTagTrait;

    const TAG_IDENTIFIER = '#EXT-X-MAP';

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $byteRange;

    /**
     * @param string
     *
     * @return self
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setByteRange($byteRange)
    {
        $this->byteRange = $byteRange;

        return $this;
    }

    /**
     * @return string
     */
    public function getByteRange()
    {
        return $this->byteRange;
    }

    public function dump()
    {
        if (empty($this->uri)) {
            return;
        }

        $attrs = [
            sprintf('URI="%s"', $this->uri)
        ];

        if (!empty($this->byteRange)) {
            $attrs[] = sprintf('BYTERANGE="%s"', $this->byteRange);
        }

        return sprintf(
            '%s:%s',
            self::TAG_IDENTIFIER,
            implode(',', $attrs)
        );
    }

    protected function read($line)
    {
        $attributes = self::extractAttributes($line);

        if (isset($attributes['URI'])) {
            $this->uri = trim($attributes['URI'], '"');
        }

        if (isset($attributes['BYTERANGE'])) {
            $this->byteRange = trim($attributes['BYTERANGE'], '"');
        }
    }
}
