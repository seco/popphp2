<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/nicksagona/PopPHP
 * @category   Pop
 * @package    Pop_Crypt
 * @author     Nick Sagona, III <info@popphp.org>
 * @copyright  Copyright (c) 2009-2014 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Crypt;

/**
 * MD5 Crypt class
 *
 * @category   Pop
 * @package    Pop_Crypt
 * @author     Nick Sagona, III <info@popphp.org>
 * @copyright  Copyright (c) 2009-2014 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.0.0a
 */
class Md5 extends AbstractCrypt
{

    /**
     * Salt
     * @var string
     */
    protected $salt = null;

    /**
     * Constructor
     *
     * Instantiate the md5 object.
     *
     * @throws Exception
     * @return self
     */
    public function __construct()
    {
        if (CRYPT_MD5 == 0) {
            throw new Exception('Error: MD5 hashing is not supported on this system.');
        }
    }

    /**
     * Method to set the salt
     *
     * @param  string $salt
     * @return self
     */
    public function setSalt($salt = null)
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * Method to get the salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Method to create the hashed value
     *
     * @param  string $string
     * @return string
     */
    public function create($string)
    {
        $hash = null;

        $this->salt = (null === $this->salt) ?
            substr(str_replace('+', '.', base64_encode($this->generateRandomString(32))), 0, 9) :
            substr(str_replace('+', '.', base64_encode($this->salt)), 0, 9);

        $hash = crypt($string, '$1$' . $this->salt);

        return $hash;
    }

    /**
     * Method to verify the hashed value
     *
     * @param  string $string
     * @param  string $hash
     * @return boolean
     */
    public function verify($string, $hash)
    {
        $result = crypt($string, $hash);
        return ($result === $hash);
    }

}
