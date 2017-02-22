<?php

class Template {
    
    private $_ci;
       
    protected $brand_name = 'todos';
    protected $title_separator = ' | ';
    protected $ga_id = FALSE;
    protected $layout = 'default';
    
    protected $theme = 'default';
    protected $title = FALSE;
    
    protected $title_desc = FALSE;
    protected $meta = array();
    protected $js = array();
    protected $css = array();
    
    const PARTIALS_DIR = "partials/";
    function __construct()
    {
        $this->_ci =& get_instance();
    }
    /**
     * Set page layout view (1 column, 2 column...)
     *
     * @access  public
     * @param   string  $layout
     * @return  void
     */
    public function set_layout($layout)
    {
        $this->layout = $layout;
    }
    
    /**
     * Set page theme view
     *
     * @access  public
     * @param   string  $theme
     * @return  void
     */
    public function set_theme($theme)
    {
        $this->theme = $theme;
    }
    /**
     * Set page title
     *
     * @access  public
     * @param   string  $title
     * @return  void
     */
    public function set_title($title)
    {
        $this->title = $title;
    }
    
    /**
     * Set page title description, a very short description of the page appended to the title after a separator.
     *
     * @access  public
     * @param   string  $title
     * @return  void
     */
    public function set_title_desc($title_desc)
    {
        $this->title_desc = $title_desc;
    }
    /**
     * Add metadata
     *
     * @access  public
     * @param   string  $name
     * @param   string  $content
     * @return  void
     */
    public function add_meta($name, $content)
    {
        $name = htmlspecialchars(strip_tags($name));
        $content = htmlspecialchars(strip_tags($content));
        $this->meta[$name] = $content;
    }
    /**
     * Add js file path
     *
     * @access  public
     * @param   string  $js
     * @return  void
     */
    public function add_js($js)
    {
        $this->js[$js] = $js;
    }
    /**
     * Add css file path
     *
     * @access  public
     * @param   string  $css
     * @return  void
     */
    public function add_css($css)
    {
        $this->css[$css] = $css;
    }
    
    
    /**
     * Load view
     *
     * @access  public
     * @param   string  $view
     * @param   mixed   $data
     * @param   boolean $return
     * @return  void
     */
    public function load_view($view, $data = array(), $return = FALSE)
    {
        // Not include master view on ajax request
        if ($this->_ci->input->is_ajax_request())
        {
            $this->_ci->load->view($view, $data);
            return;
        }
        // Title
        if($this->title){
            $title = $this->title . $this->title_separator . $this->brand_name;
        }else{
            $title = $this->brand_name;
        }
        // Title description
        if ($this->title_desc){
            $title .=  $this->title_separator . $this->title_desc;
        }
        // Metadata
        $meta = array();
        foreach ($this->meta as $name => $content)
        {
            if (strpos($name, 'og:') === 0)
            {
                $meta[] = "<meta property=\"" . $name . "\" content=\"" . $content . "\">\r\n\t";
            }
            else
            {
                $meta[] = "<meta name=\"" . $name . "\" content=\"" . $content . "\">\r\n\t";
            }
        }
        $meta = implode('', $meta);
        // Javascript
        $js = array();
        foreach ($this->js as $js_file)
        {
            $js[] = "<script src=\"" . assets_url($js_file) . "\"></script>\r\n\t";
        }
        $js = implode('', $js);
        // CSS
        $css = array();
        foreach ($this->css as $css_file)
        {
            $css[] = "<link rel=\"stylesheet\" href=\"" . assets_url($css_file) . "\">\r\n\t";
        }
        $css = implode('', $css);
        $header = $this->_ci->load->view('partials/header', array(), TRUE);
        $footer = $this->_ci->load->view('partials/footer', array(), TRUE);
        $main_content = $this->_ci->load->view($view, $data, TRUE);
        $output = $this->_ci->load->view('layouts/' . $this->layout, array(
            'header' => $header,
            'footer' => $footer,
            'main_content' => $main_content,
        ), TRUE);
        return $this->_ci->load->view('themes/'.$this->theme, array(
            'title' => $title,
            'meta' => $meta,
            'js' => $js,
            'css' => $css,
            'output' => $output,
            'ga_id' => $this->ga_id,
        ), $return);
    }
}
