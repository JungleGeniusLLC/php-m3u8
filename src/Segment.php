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

class Segment extends AbstractContainer
{
    private $extinfTag;
    private $byteRangeTag;
    private $cueoutTag;
    private $discontinuityTag;
    private $programDateTimeTag;
    private $dateRangeTag;
    private $cueinTag;
    private $streamTags;
    private $keyTags;
    private $uri;

    private $mediaSequence;
    private $discontinuitySequence;

    public function __construct($m3u8Version = null)
    {
        $this->extinfTag = new Tag\ExtinfTag($m3u8Version);
        $this->byteRangeTag = new Tag\ByteRangeTag();
        $this->cueoutTag = new Tag\CueOutTag();
        $this->discontinuityTag = new Tag\DiscontinuityTag();
        $this->programDateTimeTag = new Tag\ProgramDateTimeTag();
        $this->dateRangeTag = new Tag\DateRangeTag();
        $this->cueinTag = new Tag\CueInTag();
        $this->streamTags = new StreamTags();
        $this->keyTags = new KeyTags();
        $this->uri = new Uri();
    }

    public function setMediaSequence($mediaSequence)
    {
        $this->mediaSequence = $mediaSequence;

        return $this;
    }

    public function getMediaSequence()
    {
        return $this->mediaSequence;
    }

    public function setDiscontinuitySequence($discontinuitySequence)
    {
        $this->discontinuitySequence = $discontinuitySequence;

        return $this;
    }

    public function getDiscontinuitySequence()
    {
        return $this->discontinuitySequence;
    }

    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return Chrisyue\PhpM3u8\Tag\DiscontinuityTag
     */
    public function getDiscontinuityTag()
    {
        return $this->discontinuityTag;
    }

    public function isDiscontinuity()
    {
        return $this->discontinuityTag->isDiscontinuity();
    }

    /**
     * @return Chrisyue\PhpM3u8\Tag\ProgramDateTimeTag
     */
    public function getProgramDateTimeTag()
    {
        return $this->programDateTimeTag;
    }

    public function isProgramDateTime()
    {
        return $this->programDateTimeTag->isProgramDateTime();
    }

    /**
     * @return Chrisyue\PhpM3u8\Tag\DateRangeTag
     */
    public function getDateRangeTag()
    {
        return $this->dateRangeTag;
    }

    public function isDateRange()
    {
        return $this->dateRangeTag->isDateRange();
    }

    /**
     * @return Chrisyue\PhpM3u8\Tag\CueOutTag
     */
    public function getCueOutTag()
    {
        return $this->cueoutTag;
    }

    public function isCueOut()
    {
        return $this->cueoutTag->isCueOut();
    }

    /**
     * @return Chrisyue\PhpM3u8\Tag\CueInTag
     */
    public function getCueInTag()
    {
        return $this->cueinTag;
    }

    public function isCueIn()
    {
        return $this->cueinTag->isCueIn();
    }

    /**
     * @return Chrisyue\PhpM3u8\Tag\ExtinfTag
     */
    public function getExtinfTag()
    {
        return $this->extinfTag;
    }

    public function getDuration()
    {
        return $this->extinfTag->getDuration();
    }

    /**
     * @return Chrisyue\PhpM3u8\Tag\ByteRangeTag
     */
    public function getByteRangeTag()
    {
        return $this->byteRangeTag;
    }

    /**
     * @return Chrisyue\PhpM3u8\StreamTags
     */
    public function getStreamTags()
    {
        return $this->streamTags;
    }

    /**
     * @return Chrisyue\PhpM3u8\KeyTags
     */
    public function getKeyTags()
    {
        return $this->keyTags;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->uri->isEmpty();
    }

    protected function getComponents()
    {
        return [
            $this->streamTags,
            $this->keyTags,
            $this->programDateTimeTag,
            $this->dateRangeTag,
            $this->extinfTag,
            $this->byteRangeTag,
            $this->cueoutTag,
            $this->discontinuityTag,
            $this->cueinTag,
            $this->uri,
        ];
    }
}
