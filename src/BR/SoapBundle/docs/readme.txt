INSTALL:

    1. Add in app/AppKernel.php inside $bundles: new BR\SoapBundle\SoapBundle()
    2. Add in app/config/routing.yml:

        soap:
            resource: "@SoapBundle/Resources/config/routing.yml"
            prefix:   /soap


CREATE FUNCTIONS:

    In BR/SoapBundle/Services/ApiService.php add function with correct annotations:

    @soap : SoapCore only read functions with this annotation
    @param type $name: Parameters in
    @return type: Parameter out

    Example:

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