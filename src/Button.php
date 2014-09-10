<?php namespace Nurmanhabib\Button;

use Form;

class Button {

    public $controller  = '';
    public $options     = array(
        
        'link'      => array(
            'text'      => 'My Link',
            'url'       => '#',
        ),

        'icon'      => array(
            'icon_fw'   => false,
            'icon_size' => false,
        ),
        
        'button'    => array(
            'size'      => 'md',
            'type'      => 'primary',
            'block'     => false,
            'url'       => '#',
            'text'      => 'My Button',
            'button'    => true,
            'link'      => false,
            'input'     => false,
            'input_type'=> 'button',
            'prepend'   => array(),
            'tclass'    => '',
        ),

        'create'    => array(
            'icon'      => 'plus',
            'icon_size' => 1,
            'icon_fw'   => true,
            'size'      => 'md',
            'type'      => 'primary',
            'url'       => '',
            'text'      => 'Create',
            'button'    => true,
            'block'     => false,
        ),

        'store'     => array(
            'icon'      => 'save',
            'icon_size' => 1,
            'icon_fw'   => true,
            'size'      => 'md',
            'type'      => 'primary',
            'url'       => '',
            'text'      => 'Publish',
            'button'    => true,
            'block'     => false,
        ),

        'show'      => array(
            'icon'      => 'external-link',
            'icon_size' => 1,
            'icon_fw'   => true,
            'size'      => 'md',
            'type'      => 'success',
            'url'       => '',
            'text'      => '',
            'button'    => true,
            'block'     => false,
        ),

        'edit'      => array(
            'icon'      => 'pencil',
            'icon_size' => 1,
            'icon_fw'   => true,
            'size'      => 'xs',
            'type'      => 'info',
            'url'       => '',
            'text'      => '',
            'button'    => true,
            'block'     => false,
        ),

        'update'    => array(
            'icon'      => 'save',
            'icon_size' => 1,
            'icon_fw'   => true,
            'size'      => 'md',
            'type'      => 'default',
            'url'       => '',
            'text'      => '',
            'button'    => true,
            'block'     => false,
        ),

        'destroy'   => array(
            'icon'      => 'trash-o',
            'icon_size' => 1,
            'icon_fw'   => true,
            'size'      => 'xs',
            'type'      => 'danger',
            'url'       => '',
            'text'      => '',
            'button'    => true,
            'link'      => false,
            'input'     => false,
            'block'     => false,
        ),
    );

    public function __construct($controller = '')
    {
        return $this->controller($controller);
    }

    public function controller($controller)
    {
        $this->controller   = $controller;

        return $this;
    }

    private function generate_attr($attributes, $first_spacing = true)
    {
        $html   = '';

        foreach ($attributes as $attribute => $value)
        {
            if($html != '' || $first_spacing)
                $html   .= ' ';
                $html   .= $attribute . '="';

                if(!is_array($value))
                    $html   .= $value;

                $html   .= '"';
        }

        return $html;
    }

    // Standard for Link, Button, and Icon (FontAwesome)
    public function link($text = '', $url = '', $attr = array())
    {
        $options    = empty($options) ? array() : $options;
        $attr       = empty($attr) ? array() : $attr;
        $local      = $this->options['link'];

        $text   = !empty($text) ? $text : $local['text'];
        $url    = !empty($url) ? $url : $local['url'];

        $attr['href']   = $url;

        $html   = '<a' . $this->generate_attr($attr) . '>';
        $html   .= $text;
        $html   .= '</a>';

        return $html;
    }

    public function button($text = '', $options = array(), $attr = array())
    {
        $options        = empty($options) ? array() : $options;
        $attr           = empty($attr) ? array() : $attr;
        $local          = array_merge($this->options['button'], $options);

        // Option: button
        $size   = $local['size'];
        $type   = $local['type'];
        $block  = $local['block'];
        $url    = $local['url'];
        $text   = empty($text) ? $local['text'] : $text;
        $tclass = $local['tclass'];
        $button = $local['button'];
        $link   = $local['link'];
        $input      = $local['input'];
        $input_type = $local['input_type'];

        // Option: button class
        $class  = 'btn';
        $class  .= ' btn-' . $type;
        $class  .= ' btn-' . $size;
        $class  .= $block ? ' btn-block' : '';
        $class  .= $tclass ? ' ' . $tclass : '';

        // Merge class to attribute
        $attr['class']  = !array_key_exists('class', $attr) ? $class : $attr['class'];

        // Generate as <button> element
        if($button)
        {
            $html   = '<button' . $this->generate_attr($attr) . '>';
            $html   .= $text;
            $html   .= '</button>';
        }

        // Generate as <input> element
        if($input)
        {
            $attr['type']   = $input_type;
            $attr['value']  = $text;

            $html   = '<input' . $this->generate_attr($attr) . '>';
        }

        // Generate as <a> element
        if($link)
        {
            $html   = $this->link($text, $url, $attr);
        }

        return $html;
    }

    public function icon($icon = 'home', $options = array(), $attr = array())
    {
        $options        = empty($options) ? array() : $options;
        $attr           = empty($attr) ? array() : $attr;
        $local          = array_merge($this->options['icon'], $options);

        if($icon)
        {
            $icon       = !empty($icon) ? $icon : $local['icon'];
            $icon_fw    = $local['icon_fw'];
            $icon_size  = $local['icon_size'];

            // Option: icon class
            $class  = 'fa';
            $class  .= $icon_fw ? ' fa-fw' : '';
            $class  .= $icon_size ? ' fa-' . $icon_size . 'x' : '';
            $class  .= ' fa-' . $icon;

            // Merge class to attribute
            $attr['class']  = !array_key_exists('class', $attr) ? $class : $attr['class'];

            $html   = '<i' . $this->generate_attr($attr) . '></i>';

            return $html;
        }
        else
        {
            return '';
        }
    }

    // Generate button with icon
    public function button_icon($text = '', $icon = '', $options = array(), $attr = array())
    {
        $text   = $this->icon($icon, $options) . ' ' . $text;
        
        return $this->button($text, $options, $attr);
    }

    // Generate button with <a> element
    public function button_link($text = '', $url = '', $options = array(), $attr = array())
    {
        $local      = array('link' => true, 'url' => $url);
        $options    = array_merge($options, $local);

        return $this->button($text, $options, $attr);
    }

    // Generate button with <a> element with icon
    public function button_link_icon($text = '', $url = '', $icon = '', $options = array(), $attr = array())
    {
        $local      = array('link' => true, 'url' => $url);
        $options    = array_merge($options, $local);

        return $this->button_icon($text, $icon, $options, $attr);
    }



    /*
    *****************************
    ** Generate for Resource Controller
    *****************************
    */

    // Create
    public function create($text = '', $options = array(), $attr = array())
    {
        $options    = empty($options) ? array() : $options;
        $attr       = empty($attr) ? array() : $attr;
        $local      = array_merge($this->options['create'], $options);
        $options    = array_merge($options, $local);

        // Option: button
        $text   = !empty($text) ? $text : $local['text'];
        $url    = !empty($local['url']) ? $local['url'] : action($this->controller . '@create');
        $icon   = $local['icon'];

        return $this->button_link_icon($text, $url, $icon, $options, $attr);
    }

    // Store
    public function store($text = '', $options = array(), $attr = array())
    {
        $options    = empty($options) ? array() : $options;
        $attr       = empty($attr) ? array() : $attr;
        $local      = array_merge($this->options['store'], $options);
        $options    = array_merge($options, $local);

        // Option: text and icon
        $text   = !empty($text) ? $text : $local['text'];
        $icon   = $local['icon'];

        return $this->button_icon($text, $icon, $options, $attr);
    }

    // Show
    public function show($text = '', $id = 0, $options = array(), $attr = array())
    {
        $options        = empty($options) ? array() : $options;
        $options        = array_merge($this->options['show'], $options);
        $options['url'] = !empty($options['url']) ? $options['url'] : action($this->controller . '@show', array($id));

        return $this->create($text, $options, $attr);
    }

    // Edit
    public function edit($text = '', $id = 0, $options = array(), $attr = array())
    {
        $options        = empty($options) ? array() : $options;
        $options        = array_merge($this->options['edit'], $options);
        $options['url'] = !empty($options['url']) ? $options['url'] : action($this->controller . '@edit', array($id));

        return $this->create($text, $options, $attr);
    }

    // Update
    public function update($text = '', $options = array(), $attr = array())
    {
        $options    = empty($options) ? array() : $options;
        $options    = array_merge($this->options['update'], $options);

        return $this->store($text, $options, $attr);
    }

    // Destroy
    public function destroy($text = '', $id = 0, $options = array(), $attr = array())
    {
        $options    = empty($options) ? array() : $options;
        $attr       = empty($attr) ? array() : $attr;
        $options    = array_merge($this->options['destroy'], $options);

        $options['tclass']  = 'btn-delete';

        // Option: button
        $text   = !empty($text) ? $text : $options['text'];
        $url    = !empty($options['url']) ? $options['url'] : action($this->controller . '@destroy', array($id));

        $html   = Form::open(array('method' => 'DELETE', 'url' => $url, 'class' => 'form-inline', 'style' => 'float: left; margin-right: 3px;'));
        $html   .= $this->store($text, $options, $attr);
        $html   .= Form::close();

        return $html;
    }

}
