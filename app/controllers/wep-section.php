<?php

/** 
 * Class for one Section Controller
 */
class WEP_Section {
    private $model;
    private $view;
    private $section_data;
    private $section_template = false;
    private $section_option;

    /** Init section controller 
     *  When new Object if default $instance = new WEP_Section() => that using default model and view
     *  If yout want using other model and view: 
     *          $model = new Custom_Section_Model;
     *          $view = new Custom_Section_View; 
     *          => $instance = new WEP_Section($model, $view);
     * */
    public function __construct($input_model = false, $input_view = false) {

        /** 
         * process init slider: 
         * - assign section template name direct or case by current page template
         * - assign section option by section template
         * - assign section data by section option and some query
         */

        if (!$input_model) {
            $this->model = new WEP_Section_Model;
        } else {
            $this->model = $input_model;
        }

        if (!$input_view) {
            $this->view = new WEP_Section_View;
        } else {
            $this->view = $input_view;
        }
    }

    // Show Up news
    public function show_up($input_template = "", $input_option = [], $input_data = []) {

        // 1. get current template and update into parent
        $this->section_template = $input_template;

        // update into parent
        // $this->model->set_template($this->section_template);

        // 2. get section option of current template
        // $this->section_option = $this->model->get_section_option($this->section_template);
        $this->section_option = $input_option;

        // 3. get section data of current template and option
        // $this->section_data = $this->model->get_section_data($this->section_template, $this->section_option);
        $this->section_data = $input_data;

        // 4. Render to view
        $this->view->show_hint($input_template);
        $this->view->render($this->section_template, $this->section_option, $this->section_data);
    }
}
