<?php

/*
 *  RssMaker
 *  by summea (except for philsXMLClean()... see below)
 *
 *  philsXMLClean() from phil at lavin dot me dot uk
 *  (see: http://www.php.net/manual/en/function.htmlentities.php#97215)
 */

class RssMaker
{
    protected $rssFile;

    function __construct()
    {

    }

    function generate($data, $save_to, $strip_tags=null)
    {
        $output =
            '<?xml version="1.0" encoding="utf-8"?>
            <rss version="2.0">
                <channel>
                    <title>' . $this->philsxmlclean($data['title']) . ' : ' . $this->philsxmlclean($data['subtitle']) . '</title>
                    <description>' . $this->philsxmlclean($data['title']) . ' : ' . $this->philsxmlclean($data['subtitle']) . '</description>
                    <link>' . $this->philsxmlclean($data['heading_link']) . '</link>
                    <lastBuildDate>' . date("D, d M Y H:i:s T") . '</lastBuildDate>
                    <managingEditor>' . $this->philsxmlclean($data['managingEditor']) . '</managingEditor>
            ';

        if (isset($data['data']) && count($data) > 0) {
            // get items (stories)
            foreach ($data['data'] as $k => $v) {
                $date_modified = strtotime($v['modified']);
                $description = substr($v['entry'], 0, 400);
                $description = strip_tags($description);
                $description = ereg_replace("(\r\n|\n)", "", $description);
                $output .=
                    '    <item>
                            <title>' . $this->philsxmlclean($v['subject']) . '</title>
                            <link>' . $this->philsxmlclean($data['link']) . $v['id'] . '</link>
                            <pubDate>' . date("D, d M Y H:i:s T", $date_modified) . '</pubDate>
                            <description>' . $this->philsxmlclean($description) . '</description>
                    ';
                $output .=
                    '
                        </item>
                    ';
            }
        }

        $output .=
            '   </channel>
            </rss>';

        // write to file
        $handle = fopen($save_to, "w");
        fwrite($handle, $output);
        fclose($handle);
    }

    function philsXMLClean($strin)
    {
        $strout = null;

        for ($i = 0; $i < strlen($strin); $i++) {
            $ord = ord($strin[$i]);

            if (($ord > 0 && $ord < 32) || ($ord >= 127)) {
                $strout .= "&amp;#{$ord};";
            } else {
                switch ($strin[$i]) {
                    case '<':
                        $strout .= '&lt;';
                        break;
                    case '>':
                        $strout .= '&gt;';
                        break;
                    case '&':
                        $strout .= '&amp;';
                        break;
                    case '"':
                        $strout .= '&quot;';
                        break;
                    default:
                        $strout .= $strin[$i];
                }
            }
        }

        return $strout;
    }
}
?>
