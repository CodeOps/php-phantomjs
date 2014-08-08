<?php

/*
 * This file is part of the php-phantomjs.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace JonnyW\PhantomJs\Procedure;

use JonnyW\PhantomJs\Exception\NotExistsException;

/**
 * PHP PhantomJs
 *
 * @author Jon Wenmoth <contact@jonnyw.me>
 */
class ChainProcedureLoader implements ProcedureLoaderInterface
{
    /**
     * Procedure loader storage.
     *
     * @var array
     * @access protected
     */
    protected $procedureLoaders;

    /**
     * Internal constructor.
     *
     * @access public
     * @param  array $procedureLoaders
     */
    public function __construct(array $procedureLoaders)
    {
        $this->procedureLoaders = $procedureLoaders;
    }

    /**
     * Add procedure loader.
     *
     * @access public
     * @param  \JonnyW\PhantomJs\Procedure\ProcedureLoaderInterface $procedureLoader
     * @return void
     */
    public function addLoader(ProcedureLoaderInterface $procedureLoader)
    {
        $this->procedureLoaders[] = $procedureLoader;
    }

    /**
     * Load procedure instance by id.
     *
     * @access public
     * @param  string $id
     * @throws \InvalidArgumentException
     * @return \JonnyW\PhantomJs\Procedure\ProcedureInterface
     */
    public function load($id)
    {
        /** @var \JonnyW\PhantomJs\Procedure\ProcedureLoaderInterface $loader */
        foreach ($this->procedureLoaders as $loader) {

            try {

                $procedure = $loader->load($id);

                return $procedure;

            } catch (\Exception $e) {}

        }

        throw new \InvalidArgumentException(sprintf('No valid procedure loader could be found to load the \'%s\' procedure.', $id));
    }
}
