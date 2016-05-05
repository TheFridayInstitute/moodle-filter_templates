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
 * Html Templates - This file contains all forms generated in module setup
 *
 * @package    filter_templates
 * @copyright  2016 Friday Institute for Educational Innovation, NC State University
 * @author     Mark Samberg <mjsamber@ncsu.edu>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
require_once("$CFG->libdir/formslib.php");
class filter_template_form_category extends moodleform{
    /*
     * Sets up form to add new template categories
     */
    public function definition(){
        global $CFG;
        $mform = $this->_form; // Don't forget the underscore!

        if (isset($this->_customdata['record']) && is_object($this->_customdata['record'])) {
            $record = $this->_customdata['record'];
        }

        //Filter Template Category: ID (readonly, hidden)
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        //Filter Template Category: Title
        $mform->addElement('text', 'name', get_string('name'), array('style'=>'width: 100%')); // Add elements to your form
        $mform->setType('name', PARAM_TEXT);                   //Set type of element
        $mform->addRule('name', get_string('required'), 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 64), 'maxlength', 64, 'client');

        if (isset($record)) {
            $this->set_data($record);
            print_r($record);
        }

        $this->add_action_buttons();
    }
}