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
 * Html Templates - Admin Settings Tree
 *
 * @package    filter_templates
 * @copyright  2016 Friday Institute for Educational Innovation, NC State University
 * @author     Mark Samberg <mjsamber@ncsu.edu>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


global $CFG, $PAGE;
$ADMIN->add('filtersettings', new admin_category('filter_templates', get_string('filtername', 'filter_templates')));
$ADMIN->add('filter_templates', new admin_externalpage('filter_templates_define',  get_string('templates', 'filter_templates'),
    $CFG->wwwroot.'/local/catalog/setup.php'));
$ADMIN->add('filter_templates', new admin_externalpage('filter_templates_categories',  get_string('categories', 'filter_templates'),
    $CFG->wwwroot.'/filter/templates/setup_category.php'));


?>