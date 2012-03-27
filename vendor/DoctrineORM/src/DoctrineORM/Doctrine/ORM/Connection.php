<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace DoctrineORM\Doctrine\ORM;

use PDO,
    Doctrine\DBAL\DriverManager,
    DoctrineORM\Doctrine\Instance,
    DoctrineORM\Doctrine\Common\EventManager;

/**
 * Wrapper for Doctrine ORM connection that helps setup configuration without relying
 * entirely on Di.
 */
class Connection extends Instance
{
	/**
	 * @var Doctrine\ORM\Configuration
	 */
	protected $config;
	
	/**
	 * @var Doctrine\Common\EventManager
	 */
	protected $evm;
	
	/**
	 * Constructor
	 * 
	 * @param array 		$opts
	 * @param Configuration $config
	 * @param EventManager  $evm
	 * @param PDO 			$pdo
	 */
	public function __construct(array $params, Configuration $config, EventManager $evm, PDO $pdo = null)
	{
		if ($pdo) {
			$params['pdo'] = $pdo;
		}
		
		$this->config = $config->getInstance();
		$this->evm    = $evm->getInstance();
		
		parent::__construct($params);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DoctrineORM\Instance.Instance::loadInstance()
	 */
	protected function loadInstance()
	{
        $this->instance = DriverManager::getConnection(
            $this->opts,
            $this->config,
            $this->evm
        );		
	}
}