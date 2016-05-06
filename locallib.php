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
 * locallib.php - Library of functions available internally to this plugin
 *
 * @package    filter_templates
 * @copyright  2016 Friday Institute for Educational Innovation, NC State University
 * @author     Mark Samberg <mjsamber@ncsu.edu>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 *  Get an array of categories with the name, ID number, and count of the number of templates in each category
 * @return numerically indexed array of categories
 */
function filter_templates_get_categories(){
    global $DB;

    $templates = $DB->get_records('filter_templates',null, '','category_id');
    $t_count = array();
    foreach($templates as $t){
        if(isset($t_count[$templates->category_id]))$t_count[$templates->category_id]++;
        else $t_count[$templates->category_id] = 1;
    }

    $cat = $DB->get_records('filter_templates_cat', null, 'name');

    $return = array();
    $count=0;
    foreach($cat as $c){
        $return[$count]['id'] = $c->id;
        $return[$count]['name'] = $c->name;
        if(isset($t_count[$c->id]))$return[$count]['count'] = $t_count[$c->id];
        else $return[$count]['count'] = 0;
        $count++;
    }

    return $return;
}

/*
 * Get an array, numerically indexed, of all of the templates
 * $return array
 */
function filter_templates_get_templates(){
    global $DB;
    $categories = $DB->get_records_menu('filter_templates_cat');

    $records = $DB->get_records('filter_templates',null,'category_id, internal_title');
    $count = 0;
    $return = array();
    foreach($records as $r){
        $return[$count]['id'] = $r->id;
        $return[$count]['internal_title'] = $r->internal_title;
        $return[$count]['internal_notes'] = $r->internal_notes;
        $return[$count]['content'] = $r->content;
        $return[$count]['category_id'] = $r->category_id;
        $return[$count]['category_name'] = $categories[$r->category_id];
        $count++;
    }
    return $return;
}