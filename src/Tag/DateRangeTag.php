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

class DateRangeTag extends AbstractTag
{
    use AttributesValueTagTrait;

    const TAG_IDENTIFIER = '#EXT-X-DATERANGE';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $startdate;

    /**
     * @var string
     */
    private $enddate;

    /**
     * @var string
     */
    private $duration;

    /**
     * @var string
     */
    private $plannedduration;

    /**
     * @var string
     */
    private $scte35cmd;

    /**
     * @var string
     */
    private $scte35out;

    /**
     * @var string
     */
    private $scte35in;

    /**
     * @var string
     */
    private $endonnext;

    /**
     * @var string
     */
    private $xuuid;

    /**
     * @param string
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setStartDate($startdate)
    {
        $this->startdate = new \DateTime($startdate);

        return $this;
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->startdate;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setEndDate($enddate)
    {
        $this->enddate = new \DateTime($enddate);

        return $this;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->enddate;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setPlannedDuration($plannedduration)
    {
        $this->plannedduration = $plannedduration;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlannedDuration()
    {
        return $this->plannedduration;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setScte35Cmd($scte35cmd)
    {
        $this->scte35cmd = $scte35cmd;

        return $this;
    }

    /**
     * @return string
     */
    public function getScte35Cmd()
    {
        return $this->scte35cmd;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setScte35Out($scte35out)
    {
        $this->scte35out = $scte35out;

        return $this;
    }

    /**
     * @return string
     */
    public function getScte35Out()
    {
        return $this->scte35out;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setScte35In($scte35in)
    {
        $this->scte35in = $scte35in;

        return $this;
    }

    /**
     * @return string
     */
    public function getScte35In()
    {
        return $this->scte35in;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setEndOnNext($endonnext)
    {
        $this->endonnext = $endonnext;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndOnNext()
    {
        return $this->endonnext;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setXuuid($xuuid)
    {
        $this->xuuid = $xuuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getXuuid()
    {
        return $this->xuuid;
    }

    public function dump()
    {
        $attrs = [];
        foreach (get_object_vars($this) as $prop => $value) {

            //$timezone = null;

            if (empty($value)) {
                continue;
            }

            switch ($prop) {
                case 'id':
                    $attrs[] = sprintf('%s="%s"', 'ID', $value);
                    break;
                case 'class':
                    $attrs[] = sprintf('%s="%s"', 'CLASS', $value);
                    break;
                case 'startdate':
                    $time_zone = $value->format('P');
                    $start_date = sprintf('%s%s', substr($value->format('Y-m-d\TH:i:s.u'), 0, -3), $time_zone);
                    $attrs[] = sprintf('%s="%s"', 'START-DATE', $start_date);
                    break;
                case 'enddate':
                    $time_zone = $value->format('P');
                    $end_date = sprintf('%s%s', substr($value->format('Y-m-d\TH:i:s.u'), 0, -3), $time_zone);
                    $attrs[] = sprintf('%s="%s"', 'END-DATE', $end_date);
                    break;
                case 'duration':
                    $attrs[] = sprintf('%s=%s', 'DURATION', $value);
                    break;
                case 'plannedduration':
                    $attrs[] = sprintf('%s=%s', 'PLANNED-DURATION', $value);
                    break;
                case 'scte35cmd':
                    $attrs[] = sprintf('%s=%s', 'SCTE35-CMD', $value);
                    break;
                case 'scte35out':
                    $attrs[] = sprintf('%s=%s', 'SCTE35-OUT', $value);
                    break;
                case 'scte35in':
                    $attrs[] = sprintf('%s=%s', 'SCTE35-IN', $value);
                    break;
                case 'endonnext':
                    $attrs[] = sprintf('%s=%s', 'END-ON-NEXT', $value);
                    break;
                case 'xuuid':
                    $attrs[] = sprintf('%s="%s"', 'X-UUID', $value);
                    break;
            }

        }

        if (empty($attrs)) {
            return;
        }

        return sprintf('%s:%s', self::TAG_IDENTIFIER, implode(',', $attrs));
    }

    protected function read($line)
    {
        $attributes = self::extractAttributes($line);

        foreach ($attributes as $prop => $value) {

            switch ($prop) {
                case 'ID':
                    $this->id = trim($value, '"');
                    break;
                case 'CLASS':
                    $this->class = trim($value, '"');
                    break;
                case 'START-DATE':
                    $this->startdate = new \DateTime(trim($value, '"'));
                    break;
                case 'END-DATE':
                    $this->enddate = new \DateTime(trim($value, '"'));
                    break;
                case 'DURATION':
                    $this->duration = $value;
                    break;
                case 'PLANNED-DURATION':
                    $this->plannedduration = $value;
                    break;
                case 'SCTE35-CMD':
                    $this->scte35cmd = $value;
                    break;
                case 'SCTE35-OUT':
                    $this->scte35out = $value;
                    break;
                case 'SCTE35-IN':
                    $this->scte35in = $value;
                    break;
                case 'END-ON-NEXT':
                    $this->endonnext = $value;
                    break;
                case 'X-UUID':
                    $this->xuuid = trim($value, '"');
                    break;
            }

        }

    }
}
