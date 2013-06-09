<?php
// vim: foldmethod=marker
/**
 *  Ethna_ActionForm_Validator_Strmaxcompat_Test.php
 *
 *  @author     Yoshinari Takaoka <takaoka@beatcraft.com>
 *  @version    $Id$
 */

// {{{    Ethna_ActionForm_Validator_Strmaxcompat_Test
/**
 *  Test Case For Ethna_ActionForm(Max Validator(2.3.x compatible))
 *
 *  @access public
 */
class Ethna_ActionForm_Validator_Strmaxcompat_Test extends Ethna_UnitTestBase
{
    function setUp()
    {
        $this->af->use_validator_plugin = false;
        $this->af->clearFormVars();
        $this->af->form = array();
        $this->ae->clear();
    }

    // {{{ Validator Max string(2.3.x compatible). 
    function test_Validate_Max_String_Compatible()
    {
        $form_def = array(
                          'type'          => VAR_TYPE_STRING,
                          'form_type'     => FORM_TYPE_TEXT,
                          'required'      => true,
                          'strmaxcompat'  => '4',  // 半角4文字、全角2文字
                    );        
        $this->af->setDef('input', $form_def);
        
        //   in ascii.
        $this->af->set('input', 'abcd'); 
        $this->af->validate();
        $this->assertFalse($this->ae->isError('input'));
        $this->ae->clear();

        $this->af->set('input', 'abcde');
        $this->af->validate();
        $this->assertTrue($this->ae->isError('input'));
        $this->ae->clear();

        $this->af->set('input', 'abあ');  // 実質半角4文字
        $this->af->validate();
        $this->assertFalse($this->ae->isError('input'));
        $this->ae->clear();

        //   multibyte.
        //   内部で強制的にEUC-JPに変換される
        $this->af->set('input', 'あい');
        $this->af->validate();
        $this->assertFalse($this->ae->isError('input'));
        $this->ae->clear();

        $this->af->set('input', 'あいう');
        $this->af->validate();
        $this->assertTrue($this->ae->isError('input'));
        $this->ae->clear();

        $this->af->set('input', 'あ');
        $this->af->validate();
        $this->assertFalse($this->ae->isError('input'));

        //  TODO: Error Message Test.
    }
    // }}}
}
// }}}

?>
