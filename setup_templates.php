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
 * Html Templates - Set up categories for the templates
 *
 * @package    filter_templates
 * @copyright  2016 Friday Institute for Educational Innovation, NC State University
 * @author     Mark Samberg <mjsamber@ncsu.edu>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/// Includes
require_once("../../config.php");
require_once('setup_forms.php');
require_once('locallib.php');
/// Security
$systemcontext = context_system::instance();
require_login();
require_capability('moodle/site:config', $systemcontext);
/// Build page
$returnurl = $CFG->wwwroot.'/filter/templates/setup_templates.php';
$PAGE->set_url($returnurl);
$PAGE->set_context($systemcontext);
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('admin');


//Get the action to take
$action = optional_param('action', 0, PARAM_TEXT);
$action = (!empty($action) ? $action : 'index');

//Add new categories
if($action=="add"){
    confirm_sesskey();
    $addform = new filter_template_form_template(new moodle_url($returnurl, array('action' => 'add')));
    if($formdata = $addform->get_data()){
        $formdata->content = $formdata->content['text'];
        $DB->insert_record('filter_templates', $formdata);
    }
}

if($action=="delete"){
    confirm_sesskey();
    $id = required_param('id',PARAM_INT);
    $DB->delete_records('filter_templates',array('id'=>$id));
}

//Set up the page template
$data = new stdClass();
$data->sesskey=sesskey();
$data->url = $returnurl;
$data->deleteicon = html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/delete'), 'alt'=>get_string('delete'), 'class'=>'iconsmall'));
$data->editicon = html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('i/edit'), 'alt'=>get_string('edit'), 'class'=>'iconsmall'));



//Render the form differently if you're editing an entry vs. adding
if($action=="edit"){
    $data->heading =  $OUTPUT->heading(get_string('modify_template', 'filter_templates'));
    $id = required_param('id',PARAM_INT);
    $record = $DB->get_record('filter_templates',array('id'=>$id));
    $editform = new filter_template_form_template(new moodle_url($returnurl, array('action' => 'edit')), array('record'=>$record));
    if($formdata = $editform->get_data()){
        confirm_sesskey();
        $formdata->content = $formdata->content['text'];
        $DB->update_record('filter_templates',$formdata);
        $record = $DB->get_record('filter_templates',array('id'=>$id));
    }
    $data->id = $record->id;
    $data->preview = $record->content;
    $data->form = $editform->render();
    //Output the page template
    $PAGE->navbar->add($record->internal_title, new moodle_url('/filter/templates/setup_templates.php', array('id'=>$record->id, 'action'=>'edit')), global_navigation::TYPE_CUSTOM);
    $data->header = $OUTPUT->header();
    $data->footer = $OUTPUT->footer();
    echo $OUTPUT->render_from_template('filter_templates/edit_template', $data);
}

//If we're not editing, or we've exited edit mode, display the full page
if($action!="edit"){
    $data->heading =  $OUTPUT->heading(get_string('manage_templates', 'filter_templates'));
    //Get the list of categories
    $data->templates = filter_templates_get_templates();

    //Categories shouldn't be passed if there aren't any.
    if(count($data->templates)!=0)$data->has_templates = true;;


    //User can add a new category on the bottom of the page
    $addform = new filter_template_form_template(new moodle_url($returnurl, array('action' => 'add')));
    $data->form = $addform->render();

    //Output the page template
    $data->header = $OUTPUT->header();
    $data->footer = $OUTPUT->footer();
    echo $OUTPUT->render_from_template('filter_templates/setup_templates', $data);
}
?>