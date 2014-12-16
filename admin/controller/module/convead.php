<?php
class ControllerModuleConvead extends Controller {
    private $error = array(); 
    
    public function index() {   
        $this->language->load('module/convead');

        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('setting/setting');
                
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('convead', $this->request->post);        
                    
            $this->session->data['success'] = $this->language->get('text_success');
        }
                
        $this->data['heading_title'] = $this->language->get('heading_title');
        
        $this->data['entry_code'] = $this->language->get('entry_code');
        
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['text_no_code'] = $this->language->get('text_no_code');
        
         if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        
         if (isset($this->error['code'])) {
            $this->data['error_code'] = $this->error['code'];
        } else {
            $this->data['error_code'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
        
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        
          $this->data['breadcrumbs'] = array();

           $this->data['breadcrumbs'][] = array(
               'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
              'separator' => false
           );

           $this->data['breadcrumbs'][] = array(
               'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
              'separator' => ' :: '
           );
        
           $this->data['breadcrumbs'][] = array(
               'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/convead', 'token=' . $this->session->data['token'], 'SSL'),
              'separator' => ' :: '
           );
        
        $this->data['action'] = $this->url->link('module/convead', 'token=' . $this->session->data['token'], 'SSL');
        
        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['convead_code'])) {
            $this->data['convead_code'] = $this->request->post['convead_code'];
        } else {
            $this->data['convead_code'] = $this->config->get('convead_code');
        }    

        $this->template = 'module/convead.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
                
        $this->response->setOutput($this->render());
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/convead')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        if (!$this->request->post['convead_code']) {
            $this->error['code'] = $this->language->get('error_code');
        }
        
        if (!$this->error) {
            return true;
        } else {
            return false;
        }    
    }
    
    public function install(){
        $this->language->load('module/convead');
        $this->session->data['success'] = $this->language->get('text_install_success');
        $this->redirect($this->url->link('module/convead', 'token=' . $this->session->data['token'], 'SSL'));
    }
    
}
?>