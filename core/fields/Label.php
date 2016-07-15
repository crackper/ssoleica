<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 13/07/16
 * Time: 9:54 AM
 */

namespace SSOLeica\Core\Fields;

//use Illuminate\Support\Facades\Form;
use Illuminate\Html\FormFacade as Form;
use Zofe\Rapyd\Rapyd;
use Zofe\Rapyd\DataForm\Field\Field;

class Label extends Field {

    public $type = "label";

    public function build()
    {
        $output = "";

        if (parent::build() === false) return;

        switch ($this->status) {
            case "disabled":
            case "show":

                if ($this->type =='hidden' || $this->value == "") {
                    $output = "";
                } elseif ( (!isset($this->value)) ) {
                    $output = $this->layout['null_label'];
                } else {
                    $output = nl2br(htmlspecialchars($this->value));
                }
                $output = "<div class='help-block'>".$output."&nbsp;</div>";
                break;

            case "create":
            case "modify":
                $output = '<span class="label label-danger">'.$this->value.'</span></h3>';//Form::label($this->name, $this->value, $this->attributes);
                break;

            case "hidden":
                //$output = Form::hidden($this->name, $this->value);
                $output = '<span class="label label-danger">'.$this->value.'</span></h3>';
                break;

            default:;
        }
        $this->output = "\n".$output."\n". $this->extra_output."\n";
    }
} 