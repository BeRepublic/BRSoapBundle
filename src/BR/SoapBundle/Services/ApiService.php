<?php
namespace BR\SoapBundle\Services;

use Cms\ModelBundle\Entity\Sample;

class ApiService
{
    private $_em;

    /**
     *
     */
    public function __construct($em)
    {
        $this->_em = $em;
    }

    /**
     * @soap
     * @param string $name
     * @return integer
     */
    public function insert($name)
    {
        $sample = new Sample();
        $sample->setName($name);

        $this->_em->persist($sample);
        $this->_em->flush();

        return $sample->getId();
    }

    /**
     * @soap
     * @param integer $id
     * @param string $name
     * @return string
     */
    public function update($id, $name)
    {
        $sample = $this->_em->getRepository('ModelBundle:Sample')->find($id);
        if($sample){
            $sample->setName($name);

            $this->_em->persist($sample);
            $this->_em->flush();

            return $id.': Nombre actualizado a '.$name;
        }
        else{
            return 'No existe';
        }
    }

    /**
     * @soap
     * @param integer $id
     * @return string
     */
    public function delete($id)
    {
        $sample = $this->_em->getRepository('ModelBundle:Sample')->find($id);
        if($sample){
            $this->_em->remove($sample);
            $this->_em->flush();

            return $id.': borrado correctamente';
        }
        else{
            return 'No existe';
        }
    }

    /**
     * @soap
     * @param integer $id
     * @return string
     */
    public function get($id)
    {
        $sample = $this->_em->getRepository('ModelBundle:Sample')->find($id);

        return $sample->getName();
    }

    /**
     * @soap
     * @return string
     */
    public function getList()
    {
        $repository = $this->_em->getRepository('ModelBundle:Sample');
        $samples = $repository->getAll();

        return json_encode($samples);
    }
}