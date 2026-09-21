<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8;

class MediaTags implements DumpableInterface, \Iterator, \ArrayAccess
{
    private $tags = [];
    private $position;

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->tags[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->tags[$this->position]);
    }

    public function offsetSet($offset, $value)
    {
        if (!is_object($value) || !$value instanceof Tag\MediaTag) {
            throw new \InvalidArgumentException('Expected $value of class Chrisyue\\PhpM3u8\\Tag\\MediaTag');
        }

        if (is_null($offset)) {
            $this->add($value);

            return;
        }

        $this->tags[$offset] = $value;
    }

    /**
     * @return Chrisyue\PhpM3u8\Tag\MediaTag
     */
    public function offsetGet($offset)
    {
        return $this->tags[$offset];
    }

    /**
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->tags[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->tags[$offset]);
    }

    public function add(Tag\MediaTag $tag)
    {
        $this->tags[] = $tag;
    }

    public function readLines(array &$lines)
    {
        while (true) {
            $tag = new Tag\MediaTag();
            $tag->readLines($lines);

            if (null === $tag->getType()) {
                return;
            }

            $this->tags[] = $tag;
        }
    }

    public function dump()
    {
        return implode("\n", array_map(function (Tag\MediaTag $tag) {
            return $tag->dump();
        }, $this->tags));
    }
}
