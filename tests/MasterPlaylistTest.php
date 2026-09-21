<?php

namespace Chrisyue\PhpM3u8\tests;

use Chrisyue\PhpM3u8\M3u8;
use PHPUnit\Framework\TestCase;

class MasterPlaylistTest extends TestCase
{
    public function testReadAndDumpStreamInfAndMedia()
    {
        $input = <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:6
#EXT-X-INDEPENDENT-SEGMENTS
#EXT-X-STREAM-INF:BANDWIDTH=2112000,CODECS="avc1.4D401F,mp4a.40.2",RESOLUTION=1280x720,FRAME-RATE=30,AUDIO="audio",CLOSED-CAPTIONS=NONE
http://192.168.118.129/appapi/v1/livemedia/uuid/720/index.m3u8
#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID="audio",NAME="2",LANGUAGE="por",AUTOSELECT=YES,URI="http://192.168.118.129/appapi/v1/livemedia/uuid/audio/index.m3u8",CHANNELS="2"
M3U8;

        $m3u8 = new M3u8();
        $m3u8->read($input);

        $streamTag = $m3u8->getSegments()->offsetGet(0)->getStreamTags()->offsetGet(0);
        $this->assertEquals('2112000', $streamTag->getBandwidth());
        $this->assertEquals('1280x720', $streamTag->getResolution());
        $this->assertEquals('avc1.4D401F,mp4a.40.2', $streamTag->getCodecs());
        $this->assertEquals('30', $streamTag->getFrameRate());
        $this->assertEquals('audio', $streamTag->getAudio());
        $this->assertEquals('NONE', $streamTag->getClosedCaptions());

        $mediaTag = $m3u8->getMediaTags()->offsetGet(0);
        $this->assertEquals('AUDIO', $mediaTag->getType());
        $this->assertEquals('audio', $mediaTag->getGroupId());
        $this->assertEquals('2', $mediaTag->getName());
        $this->assertEquals('por', $mediaTag->getLanguage());
        $this->assertEquals('YES', $mediaTag->getAutoselect());
        $this->assertEquals('http://192.168.118.129/appapi/v1/livemedia/uuid/audio/index.m3u8', $mediaTag->getUri());
        $this->assertEquals('2', $mediaTag->getChannels());

        $expected = <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:6
#EXT-X-STREAM-INF:BANDWIDTH=2112000,RESOLUTION=1280x720,CODECS="avc1.4D401F,mp4a.40.2",FRAME-RATE=30,AUDIO="audio",CLOSED-CAPTIONS=NONE
http://192.168.118.129/appapi/v1/livemedia/uuid/720/index.m3u8
#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID="audio",NAME="2",LANGUAGE="por",AUTOSELECT=YES,URI="http://192.168.118.129/appapi/v1/livemedia/uuid/audio/index.m3u8",CHANNELS="2"
M3U8;

        $this->assertEquals($expected, $m3u8->dump());
    }

    public function testMediaFixedDumpOrderAndQuotedCommaValues()
    {
        $input = <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:6
#EXT-X-MEDIA:URI="audio/index.m3u8?token=a=b",CHANNELS="6",CHARACTERISTICS="public.accessibility.describes-video,public.accessibility.transcribes-spoken-dialog",AUTOSELECT=YES,DEFAULT=NO,LANGUAGE="en",NAME="English",GROUP-ID="audio",TYPE=AUDIO
M3U8;

        $m3u8 = new M3u8();
        $m3u8->read($input);

        $mediaTag = $m3u8->getMediaTags()->offsetGet(0);
        $this->assertEquals('audio/index.m3u8?token=a=b', $mediaTag->getUri());
        $this->assertEquals('public.accessibility.describes-video,public.accessibility.transcribes-spoken-dialog', $mediaTag->getCharacteristics());

        $this->assertEquals(
            '#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID="audio",NAME="English",LANGUAGE="en",DEFAULT=NO,AUTOSELECT=YES,CHARACTERISTICS="public.accessibility.describes-video,public.accessibility.transcribes-spoken-dialog",URI="audio/index.m3u8?token=a=b",CHANNELS="6"',
            $mediaTag->dump()
        );
    }
}
