<?php
/**
 * DTOx
 *
 * @copyright   Copyright (c) 2012, Jason Fox (jasonrobertfox.com)
 * @license     http://opensource.org/licenses/MIT
 * @author      Jason Fox <jasonrobertfox@gmail.com>
 */

namespace DTOx\Generator;

use DTOx\Generator\DTO;

/**
 * @package    DTOx\Generator
 */
class DTOTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function validInitializeGenerator()
    {
        $generator = $this->getValidDTO();
        $this->assertInstanceOf('DTOx\Generator\DTO', $generator, 'instance of');
    }

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function returnValidCodeForSimpleDTO()
    {
        $generator = $this->getValidDTO();
        $this->assertEquals($this->validCodeOutput(), $generator->generate(), 'generate');
    }

    /**
     * @test
     * @group generator
     * @group generator-dto
     */
    public function returnValidCodeRegardlessOfCase()
    {
        $generator = $this->getRubyCaseDTO();
        $this->assertEquals($this->validCodeOutput(), $generator->generate(), 'generate');
    }

    private function getValidDTO()
    {
        return new DTO('WidgetDTO', 'Company\Application', array('id'=>'string', 'name'=>'string'));
    }

    private function getRubyCaseDTO()
    {
        return new DTO('wiDget_d_t_o', 'company\application', array('id'=>'string', 'name'=>'string'));
    }

    private function validCodeOutput()
    {
        return '<?php
namespace Company\Application;

/**
 * @package Company\Application
 */
class WidgetDTO implements \Serializable
{

    /**
     * @var string $id
     */
    private $id = null;

    /**
     * @var string $name
     */
    private $name = null;

    /**
     * @param string $id
     * @param string $name
     * @return void
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Serializable::serialize()
     * @return string
     */
    public function serialize()
    {
        $data = get_object_vars($this);
        return serialize($data);
    }

    /**
     * (non-PHPdoc)
     *
     * @see Serializable::serialize()
     * @param string $data
     * @return void
     */
    public function unserialize($data)
    {
        $object = unserialize($data);
        foreach ($object as $variable => $value) {
            $this->$variable = $value;
        }
    }
}
';
    }

}
