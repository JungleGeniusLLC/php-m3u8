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

class MediaTag extends AbstractTag
{
    use SingleValueTagTrait;

    const TAG_IDENTIFIER = '#EXT-X-MEDIA';

    /** @var string */
    private $type;

    /** @var string */
    private $groupId;

    /** @var string */
    private $name;

    /** @var string */
    private $language;

    /** @var string */
    private $assocLanguage;

    /** @var string */
    private $default;

    /** @var string */
    private $autoselect;

    /** @var string */
    private $forced;

    /** @var string */
    private $instreamId;

    /** @var string */
    private $characteristics;

    /** @var string */
    private $uri;

    /** @var string */
    private $channels;

    /**
     * @param string
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /** @return string */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /** @return string */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /** @return string */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /** @return string */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setAssocLanguage($assocLanguage)
    {
        $this->assocLanguage = $assocLanguage;

        return $this;
    }

    /** @return string */
    public function getAssocLanguage()
    {
        return $this->assocLanguage;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /** @return string */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setAutoselect($autoselect)
    {
        $this->autoselect = $autoselect;

        return $this;
    }

    /** @return string */
    public function getAutoselect()
    {
        return $this->autoselect;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setForced($forced)
    {
        $this->forced = $forced;

        return $this;
    }

    /** @return string */
    public function getForced()
    {
        return $this->forced;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setInstreamId($instreamId)
    {
        $this->instreamId = $instreamId;

        return $this;
    }

    /** @return string */
    public function getInstreamId()
    {
        return $this->instreamId;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setCharacteristics($characteristics)
    {
        $this->characteristics = $characteristics;

        return $this;
    }

    /** @return string */
    public function getCharacteristics()
    {
        return $this->characteristics;
    }

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

    /** @return string */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setChannels($channels)
    {
        $this->channels = $channels;

        return $this;
    }

    /** @return string */
    public function getChannels()
    {
        return $this->channels;
    }

    public function dump()
    {
        $attrs = [];

        // Dump order is fixed and independent of the order parsed from the input line.
        $this->appendAttribute($attrs, 'TYPE', $this->type, false);
        $this->appendAttribute($attrs, 'GROUP-ID', $this->groupId, true);
        $this->appendAttribute($attrs, 'NAME', $this->name, true);
        $this->appendAttribute($attrs, 'LANGUAGE', $this->language, true);
        $this->appendAttribute($attrs, 'ASSOC-LANGUAGE', $this->assocLanguage, true);
        $this->appendAttribute($attrs, 'DEFAULT', $this->default, false);
        $this->appendAttribute($attrs, 'AUTOSELECT', $this->autoselect, false);
        $this->appendAttribute($attrs, 'FORCED', $this->forced, false);
        $this->appendAttribute($attrs, 'INSTREAM-ID', $this->instreamId, true);
        $this->appendAttribute($attrs, 'CHARACTERISTICS', $this->characteristics, true);
        $this->appendAttribute($attrs, 'URI', $this->uri, true);
        $this->appendAttribute($attrs, 'CHANNELS', $this->channels, true);

        if (empty($attrs)) {
            return;
        }

        return sprintf('%s:%s', self::TAG_IDENTIFIER, implode(',', $attrs));
    }

    protected function read($line)
    {
        $attrs = preg_split("/,(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/", self::extractValue($line));
        $attributes = [];
        foreach ($attrs as $attr) {
            $parts = explode('=', $attr, 2);
            if (2 !== count($parts)) {
                continue;
            }
            $attributes[$parts[0]] = trim($parts[1]);
        }

        $this->type = $this->readAttribute($attributes, 'TYPE', false);
        $this->groupId = $this->readAttribute($attributes, 'GROUP-ID', true);
        $this->name = $this->readAttribute($attributes, 'NAME', true);
        $this->language = $this->readAttribute($attributes, 'LANGUAGE', true);
        $this->assocLanguage = $this->readAttribute($attributes, 'ASSOC-LANGUAGE', true);
        $this->default = $this->readAttribute($attributes, 'DEFAULT', false);
        $this->autoselect = $this->readAttribute($attributes, 'AUTOSELECT', false);
        $this->forced = $this->readAttribute($attributes, 'FORCED', false);
        $this->instreamId = $this->readAttribute($attributes, 'INSTREAM-ID', true);
        $this->characteristics = $this->readAttribute($attributes, 'CHARACTERISTICS', true);
        $this->uri = $this->readAttribute($attributes, 'URI', true);
        $this->channels = $this->readAttribute($attributes, 'CHANNELS', true);
    }

    private function appendAttribute(array &$attrs, $key, $value, $quoted)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if ($quoted) {
            $attrs[] = sprintf('%s="%s"', $key, $value);
        } else {
            $attrs[] = sprintf('%s=%s', $key, $value);
        }
    }

    private function readAttribute(array $attributes, $key, $quoted)
    {
        if (!isset($attributes[$key])) {
            return;
        }

        return $quoted ? trim($attributes[$key], '"') : $attributes[$key];
    }
}
