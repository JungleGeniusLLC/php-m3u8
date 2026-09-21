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

class StreamTag extends AbstractTag
{
    use SingleValueTagTrait;

    const TAG_IDENTIFIER = '#EXT-X-STREAM-INF';

    /**
     * @var string
     */
    private $programId;

    /**
     * @var string
     */
    private $bandwidth;

    /**
     * @var string
     */
    private $resolution;

    /**
     * @var string
     */
    private $codecs;

    /**
     * @var string
     */
    private $frameRate;

    /**
     * @var string
     */
    private $audio;

    /**
     * @var string
     */
    private $video;

    /**
     * @var string
     */
    private $subtitles;

    /**
     * @var string
     */
    private $closedCaptions;

    /**
     * @param string
     *
     * @return self
     */
    public function setProgramId($programId)
    {
        $this->programId = $programId;

        return $this;
    }

    /**
     * @return string
     */
    public function getProgramId()
    {
        return $this->programId;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setBandwidth($bandwidth)
    {
        $this->bandwidth = $bandwidth;

        return $this;
    }

    /**
     * @return string
     */
    public function getBandwidth()
    {
        return $this->bandwidth;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setCodecs($codecs)
    {
        $this->codecs = $codecs;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodecs()
    {
        return $this->codecs;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setFrameRate($frameRate)
    {
        $this->frameRate = $frameRate;

        return $this;
    }

    /**
     * @return string
     */
    public function getFrameRate()
    {
        return $this->frameRate;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setAudio($audio)
    {
        $this->audio = $audio;

        return $this;
    }

    /**
     * @return string
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setSubtitles($subtitles)
    {
        $this->subtitles = $subtitles;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubtitles()
    {
        return $this->subtitles;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setClosedCaptions($closedCaptions)
    {
        $this->closedCaptions = $closedCaptions;

        return $this;
    }

    /**
     * @return string
     */
    public function getClosedCaptions()
    {
        return $this->closedCaptions;
    }

    public function dump()
    {
        $attrs = [];
        foreach (get_object_vars($this) as $prop => $value) {
            if (empty($value)) {
                continue;
            }

            if ('codecs' === $prop || 'audio' === $prop || 'video' === $prop || 'subtitles' === $prop) {
                $attrs[] = sprintf('%s="%s"', strtoupper($prop), $value);
                continue;
            }

            if ('programId' === $prop) {
                $attrs[] = sprintf('%s=%s', 'PROGRAM-ID', $value);
                continue;
            }

            if ('frameRate' === $prop) {
                $attrs[] = sprintf('%s=%s', 'FRAME-RATE', $value);
                continue;
            }

            if ('closedCaptions' === $prop) {
                if ('NONE' === strtoupper($value)) {
                    $attrs[] = sprintf('%s=%s', 'CLOSED-CAPTIONS', 'NONE');
                } else {
                    $attrs[] = sprintf('%s="%s"', 'CLOSED-CAPTIONS', $value);
                }
                continue;
            }

            $attrs[] = sprintf('%s=%s', strtoupper($prop), $value);
        }

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
            list($key, $value) = explode('=', $attr);
            $attributes[$key] = trim($value);
        }

        foreach (get_object_vars($this) as $prop => $value) {
            $key = strtoupper($prop);
            if ('frameRate' === $prop) {
                $key = 'FRAME-RATE';
            } elseif ('closedCaptions' === $prop) {
                $key = 'CLOSED-CAPTIONS';
            }

            if (isset($attributes[$key])) {
                if ('codecs' === $prop || 'audio' === $prop || 'video' === $prop || 'subtitles' === $prop || 'closedCaptions' === $prop) {
                    $this->$prop = trim($attributes[$key], '",');
                    continue;
                }
                $this->$prop = trim($attributes[$key], ',');
            }
        }
        if (isset($attributes['PROGRAM-ID'])) {
            $this->programId = trim($attributes['PROGRAM-ID'], ',');
        }
    }
}
