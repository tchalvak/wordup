<?php

// Collection of the php functions for the wordup dictionary app.

function string_cleaning ($string,$remove,$replace) {
    foreach ($remove as $it) {
        $string = str_replace($it,$replace,$string);
        }
    return $string;
}

function tag_line ($url,$siteName) {
    return "<table width=100%>
             <tr>
              <td align=right class=tagline height=34px valign=bottom>
               ( <a href='".$url."'>more at ".$siteName."</a> )
              </td>
             </tr>
            </table>";
    }

function dictionary_header ($partOfSpeech,$yearFirstUsed) {
    return "<table width=100%>
             <tr>
              <td align=right>
               <span class=subtext>".$yearFirstUsed."</span> <span class=dates>(".$partOfSpeech.")</span>
              </td>
             </tr>
            </table>";
    }

function get_dictionary ($theQuery,$theWord) {
    //MERRIAM-WEBSTER COLLEGIATE DICTIONARY
    $url = "http://www.dictionaryapi.com/api/v1/references/collegiate/xml/".$theQuery."?key=fdc0715f-87eb-4a06-bc48-fe6da57bdbeb";
    $link = "http://www.merriam-webster.com/dictionary/".$theQuery;
    $xml = simplexml_load_string(file_get_contents($url));
    foreach($xml->entry as $thisEntry) {
      if ($thisEntry->ew == $theWord) {
        foreach($thisEntry->def as $def) {
          $content .= "<p>".dictionary_header($thisEntry->fl, $thisEntry->def->date)."</p>";
          foreach($def->dt as $dt) {
            $content .= "<p>".strip_tags($dt->asXML())."</p>";
          }
        }
      }
    }
    if ($content != "") {
      return string_cleaning($content,array("  ", ": ", " :", ":"),"").tag_line($link,"merriam-webster");
    } else {
      return "no results at merriam-webster";
    }
}

function get_slang ($theQuery) {
    //URBAN DICTIONARY
    $url = "http://api.urbandictionary.com/v0/define?term=".$theQuery;
    $link = "http://www.urbandictionary.com/define.php?term=".$theQuery;
    $obj = json_decode(file_get_contents($url));
    if (isset($obj->list[0]->definition))
      return "<p>".$obj->list[0]->definition."</p>".
             "<p><i>".$obj->list[0]->example."</i></p>".
             tag_line($link,"urban dictionary");
    else return "no results at urban dictionary";
}

function get_thesaurus ($theQuery) {
    //ALTERVISTA by way of WIKISAURUS
    $url = "http://thesaurus.altervista.org/thesaurus/v1?word=".$theQuery."&language=en_US&key=hxOhANiwzBrCfVum3GIH&output=json";
    $link = "http://en.wiktionary.org/wiki/".$theQuery."#Synonyms";
    $obj = json_decode(file_get_contents($url));
    if (isset($obj->response)) {
      foreach ($obj->response as $response) {
        $content .= "<p><span class=dates>".$response->list->{'category'}."</span> ".
                    string_cleaning($response->list->{'synonyms'},array(" (similar term)"," (related term)"),"").
                    "</p>";
      }
    }
    if ($content != "") {
      return string_cleaning($content,array("|"),", ").tag_line($link,"wikisaurus");
    } else {
      return "no results at wikisaurus";
    }
}