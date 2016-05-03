<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Html Templates - Filter Class
 *
 * @package    filter_templates
 * @copyright  2016 Friday Institute for Educational Innovation, NC State University
 * @author     Mark Samberg <mjsamber@ncsu.edu>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

/**
 * Template Filtering
 */
class filter_templates extends moodle_text_filter
{

    /*
     * Search
     *
     * @param string $moodlelangcode - The moodle language code - e.g. en_pirate
     * @return string Moodle output with templates inserted
     */
    public function filter($text, array $options = array()) {
        $search = "/(\[\[(template )\d+\]\])/i";
        $text = preg_replace_callback($search, array($this, 'get_template'), $text);
        return $text;
    }


    /*
     * Callback function - processes the regular expression matches from preg_replace_callback function in the filter method.
     * #param array $matches - Array with element zero being the entire matched regex, and subsequent elements being token matches
     */
    public function get_template(array $matches){
        global $DB;

        $id = $matches[0];
        //Strip away everything except for the ID number of the template
        $id = str_replace("[[", "", $id);
        $id = str_replace("]]", "", $id);
        $id = str_ireplace("template ", "", $id);

        if(!$DB->record_exists('filter_templates',array('id'=>$id)))return get_string('norecord','filter_templates',$id);

        $record =  $DB->get_record('filter_templates', array('id'=>$id));

        return $record->content;

    }
}
?>