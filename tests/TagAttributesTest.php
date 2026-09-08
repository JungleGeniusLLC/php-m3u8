<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\tests;

use Chrisyue\PhpM3u8\Tag\CueOutTag;
use Chrisyue\PhpM3u8\Tag\DateRangeTag;
use Chrisyue\PhpM3u8\Tag\KeyTag;
use Chrisyue\PhpM3u8\Tag\MapTag;
use PHPUnit\Framework\TestCase;

class TagAttributesTest extends TestCase
{
    public function testDateRangeParsesWhitespaceBeforeAttributeAndDumpsCanonicalAttributes()
    {
        $lines = [
            '#EXT-X-DATERANGE:ID="662-0000", START-DATE="2026-09-07T22:51:27.313Z",PLANNED-DURATION=242,SCTE35-OUT=0xFC00',
        ];

        $tag = new DateRangeTag();
        $tag->readLines($lines);

        $this->assertEquals('662-0000', $tag->getId());
        $this->assertEquals('2026-09-07T22:51:27.313+00:00', $tag->getStartDate()->format('Y-m-d\\TH:i:s.vP'));
        $this->assertEquals('242', $tag->getPlannedDuration());
        $this->assertEquals('0xFC00', $tag->getScte35Out());
        $this->assertEquals(
            '#EXT-X-DATERANGE:ID="662-0000",START-DATE="2026-09-07T22:51:27.313+00:00",PLANNED-DURATION=242,SCTE35-OUT=0xFC00',
            $tag->dump()
        );
    }

    public function testKeyUriWithQueryEqualsParsesAndDumpsWithoutTruncation()
    {
        $uri = 'http://192.168.118.129/appapi/v1/hlskeypayload/5540b1f0-2cd2-11ee-a71d-fd02cbc1ae8b?xyz=0&ttl=1788910314&pass=2c93ecb6191e874334b082cd5f4dbcb7';
        $lines = [
            '#EXT-X-KEY:METHOD=AES-128,URI="'.$uri.'",IV=0x11d84454365bc939f757ce461ca8b92b',
        ];

        $tag = new KeyTag();
        $tag->readLines($lines);

        $this->assertEquals('AES-128', $tag->getMethod());
        $this->assertEquals($uri, $tag->getUri());
        $this->assertEquals('0x11d84454365bc939f757ce461ca8b92b', $tag->getIv());
        $this->assertEquals(
            '#EXT-X-KEY:METHOD=AES-128,URI="'.$uri.'",IV=0x11d84454365bc939f757ce461ca8b92b',
            $tag->dump()
        );
    }

    public function testMapUriWithQueryEqualsParsesAndDumpsWithoutTruncation()
    {
        $uri = 'http://192.168.118.129/appapi/v1/segment/640x5e2b02207abf11efa8a7239b4eabb0dfx/640x5e2b02207abf11efa8a7239b4eabb0dfx.m4s?ttl=1788910314&pass=6d2a9670b8563e6b9eb965b2c9d4a3d3';
        $lines = [
            '#EXT-X-MAP:URI="'.$uri.'"',
        ];

        $tag = new MapTag();
        $tag->readLines($lines);

        $this->assertEquals($uri, $tag->getUri());
        $this->assertEquals('#EXT-X-MAP:URI="'.$uri.'"', $tag->dump());
    }
    public function testCueOutParsesAndDumpsSingleValue()
    {
        $lines = [
            '#EXT-X-CUE-OUT:30.000',
        ];

        $tag = new CueOutTag();
        $tag->readLines($lines);

        $this->assertEquals('30.000', $tag->isCueOut());
        $this->assertEquals('#EXT-X-CUE-OUT:30.000', $tag->dump());
    }

}
