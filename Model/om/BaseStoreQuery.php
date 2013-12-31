<?php

namespace Dzangocart\Bundle\CoreBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Dzangocart\Bundle\CoreBundle\Model\Store;
use Dzangocart\Bundle\CoreBundle\Model\StorePeer;
use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

/**
 * @method StoreQuery orderById($order = Criteria::ASC) Order by the id column
 * @method StoreQuery orderByOwnerId($order = Criteria::ASC) Order by the owner_id column
 * @method StoreQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method StoreQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method StoreQuery orderByRcs($order = Criteria::ASC) Order by the rcs column
 * @method StoreQuery orderBySiren($order = Criteria::ASC) Order by the siren column
 * @method StoreQuery orderByNaf($order = Criteria::ASC) Order by the naf column
 * @method StoreQuery orderByVatId($order = Criteria::ASC) Order by the vat_id column
 * @method StoreQuery orderByAddressId($order = Criteria::ASC) Order by the address_id column
 * @method StoreQuery orderByBillRegAddress($order = Criteria::ASC) Order by the bill_reg_address column
 * @method StoreQuery orderByBillingAddressId($order = Criteria::ASC) Order by the billing_address_id column
 * @method StoreQuery orderByTelephone($order = Criteria::ASC) Order by the telephone column
 * @method StoreQuery orderByFax($order = Criteria::ASC) Order by the fax column
 * @method StoreQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method StoreQuery orderByDomain($order = Criteria::ASC) Order by the domain column
 * @method StoreQuery orderByRealm($order = Criteria::ASC) Order by the realm column
 * @method StoreQuery orderByHost($order = Criteria::ASC) Order by the host column
 * @method StoreQuery orderByHostname($order = Criteria::ASC) Order by the hostname column
 * @method StoreQuery orderByWebsite($order = Criteria::ASC) Order by the website column
 * @method StoreQuery orderByLogo($order = Criteria::ASC) Order by the logo column
 * @method StoreQuery orderByCurrencyId($order = Criteria::ASC) Order by the currency_id column
 * @method StoreQuery orderByTaxIncluded($order = Criteria::ASC) Order by the tax_included column
 * @method StoreQuery orderByDefaultCategoryId($order = Criteria::ASC) Order by the default_category_id column
 * @method StoreQuery orderByLoading($order = Criteria::ASC) Order by the loading column
 * @method StoreQuery orderByTemplateMinified($order = Criteria::ASC) Order by the template_minified column
 * @method StoreQuery orderByKey($order = Criteria::ASC) Order by the key column
 * @method StoreQuery orderByTestcode($order = Criteria::ASC) Order by the testcode column
 * @method StoreQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method StoreQuery orderBySuspended($order = Criteria::ASC) Order by the suspended column
 * @method StoreQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method StoreQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method StoreQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method StoreQuery orderByDeletedAt($order = Criteria::ASC) Order by the deleted_at column
 * @method StoreQuery orderByPlanId($order = Criteria::ASC) Order by the plan_id column
 * @method StoreQuery orderByExpiresAt($order = Criteria::ASC) Order by the expires_at column
 * @method StoreQuery orderByAffiliateId($order = Criteria::ASC) Order by the affiliate_id column
 * @method StoreQuery orderByOauthToken($order = Criteria::ASC) Order by the oauth_token column
 * @method StoreQuery orderByYearEnd($order = Criteria::ASC) Order by the year_end column
 * @method StoreQuery orderByCountryId($order = Criteria::ASC) Order by the country_id column
 *
 * @method StoreQuery groupById() Group by the id column
 * @method StoreQuery groupByOwnerId() Group by the owner_id column
 * @method StoreQuery groupByName() Group by the name column
 * @method StoreQuery groupByTypeId() Group by the type_id column
 * @method StoreQuery groupByRcs() Group by the rcs column
 * @method StoreQuery groupBySiren() Group by the siren column
 * @method StoreQuery groupByNaf() Group by the naf column
 * @method StoreQuery groupByVatId() Group by the vat_id column
 * @method StoreQuery groupByAddressId() Group by the address_id column
 * @method StoreQuery groupByBillRegAddress() Group by the bill_reg_address column
 * @method StoreQuery groupByBillingAddressId() Group by the billing_address_id column
 * @method StoreQuery groupByTelephone() Group by the telephone column
 * @method StoreQuery groupByFax() Group by the fax column
 * @method StoreQuery groupByEmail() Group by the email column
 * @method StoreQuery groupByDomain() Group by the domain column
 * @method StoreQuery groupByRealm() Group by the realm column
 * @method StoreQuery groupByHost() Group by the host column
 * @method StoreQuery groupByHostname() Group by the hostname column
 * @method StoreQuery groupByWebsite() Group by the website column
 * @method StoreQuery groupByLogo() Group by the logo column
 * @method StoreQuery groupByCurrencyId() Group by the currency_id column
 * @method StoreQuery groupByTaxIncluded() Group by the tax_included column
 * @method StoreQuery groupByDefaultCategoryId() Group by the default_category_id column
 * @method StoreQuery groupByLoading() Group by the loading column
 * @method StoreQuery groupByTemplateMinified() Group by the template_minified column
 * @method StoreQuery groupByKey() Group by the key column
 * @method StoreQuery groupByTestcode() Group by the testcode column
 * @method StoreQuery groupByActive() Group by the active column
 * @method StoreQuery groupBySuspended() Group by the suspended column
 * @method StoreQuery groupByStatus() Group by the status column
 * @method StoreQuery groupByCreatedAt() Group by the created_at column
 * @method StoreQuery groupByUpdatedAt() Group by the updated_at column
 * @method StoreQuery groupByDeletedAt() Group by the deleted_at column
 * @method StoreQuery groupByPlanId() Group by the plan_id column
 * @method StoreQuery groupByExpiresAt() Group by the expires_at column
 * @method StoreQuery groupByAffiliateId() Group by the affiliate_id column
 * @method StoreQuery groupByOauthToken() Group by the oauth_token column
 * @method StoreQuery groupByYearEnd() Group by the year_end column
 * @method StoreQuery groupByCountryId() Group by the country_id column
 *
 * @method StoreQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StoreQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StoreQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Store findOne(PropelPDO $con = null) Return the first Store matching the query
 * @method Store findOneOrCreate(PropelPDO $con = null) Return the first Store matching the query, or a new Store object populated from the query conditions when no match is found
 *
 * @method Store findOneByOwnerId(int $owner_id) Return the first Store filtered by the owner_id column
 * @method Store findOneByName(string $name) Return the first Store filtered by the name column
 * @method Store findOneByTypeId(int $type_id) Return the first Store filtered by the type_id column
 * @method Store findOneByRcs(string $rcs) Return the first Store filtered by the rcs column
 * @method Store findOneBySiren(string $siren) Return the first Store filtered by the siren column
 * @method Store findOneByNaf(string $naf) Return the first Store filtered by the naf column
 * @method Store findOneByVatId(string $vat_id) Return the first Store filtered by the vat_id column
 * @method Store findOneByAddressId(int $address_id) Return the first Store filtered by the address_id column
 * @method Store findOneByBillRegAddress(int $bill_reg_address) Return the first Store filtered by the bill_reg_address column
 * @method Store findOneByBillingAddressId(int $billing_address_id) Return the first Store filtered by the billing_address_id column
 * @method Store findOneByTelephone(string $telephone) Return the first Store filtered by the telephone column
 * @method Store findOneByFax(string $fax) Return the first Store filtered by the fax column
 * @method Store findOneByEmail(string $email) Return the first Store filtered by the email column
 * @method Store findOneByDomain(string $domain) Return the first Store filtered by the domain column
 * @method Store findOneByRealm(string $realm) Return the first Store filtered by the realm column
 * @method Store findOneByHost(string $host) Return the first Store filtered by the host column
 * @method Store findOneByHostname(string $hostname) Return the first Store filtered by the hostname column
 * @method Store findOneByWebsite(string $website) Return the first Store filtered by the website column
 * @method Store findOneByLogo(string $logo) Return the first Store filtered by the logo column
 * @method Store findOneByCurrencyId(string $currency_id) Return the first Store filtered by the currency_id column
 * @method Store findOneByTaxIncluded(int $tax_included) Return the first Store filtered by the tax_included column
 * @method Store findOneByDefaultCategoryId(int $default_category_id) Return the first Store filtered by the default_category_id column
 * @method Store findOneByLoading(string $loading) Return the first Store filtered by the loading column
 * @method Store findOneByTemplateMinified(string $template_minified) Return the first Store filtered by the template_minified column
 * @method Store findOneByKey(string $key) Return the first Store filtered by the key column
 * @method Store findOneByTestcode(string $testcode) Return the first Store filtered by the testcode column
 * @method Store findOneByActive(boolean $active) Return the first Store filtered by the active column
 * @method Store findOneBySuspended(boolean $suspended) Return the first Store filtered by the suspended column
 * @method Store findOneByStatus(int $status) Return the first Store filtered by the status column
 * @method Store findOneByCreatedAt(string $created_at) Return the first Store filtered by the created_at column
 * @method Store findOneByUpdatedAt(string $updated_at) Return the first Store filtered by the updated_at column
 * @method Store findOneByDeletedAt(string $deleted_at) Return the first Store filtered by the deleted_at column
 * @method Store findOneByPlanId(int $plan_id) Return the first Store filtered by the plan_id column
 * @method Store findOneByExpiresAt(string $expires_at) Return the first Store filtered by the expires_at column
 * @method Store findOneByAffiliateId(int $affiliate_id) Return the first Store filtered by the affiliate_id column
 * @method Store findOneByOauthToken(string $oauth_token) Return the first Store filtered by the oauth_token column
 * @method Store findOneByYearEnd(boolean $year_end) Return the first Store filtered by the year_end column
 * @method Store findOneByCountryId(string $country_id) Return the first Store filtered by the country_id column
 *
 * @method array findById(int $id) Return Store objects filtered by the id column
 * @method array findByOwnerId(int $owner_id) Return Store objects filtered by the owner_id column
 * @method array findByName(string $name) Return Store objects filtered by the name column
 * @method array findByTypeId(int $type_id) Return Store objects filtered by the type_id column
 * @method array findByRcs(string $rcs) Return Store objects filtered by the rcs column
 * @method array findBySiren(string $siren) Return Store objects filtered by the siren column
 * @method array findByNaf(string $naf) Return Store objects filtered by the naf column
 * @method array findByVatId(string $vat_id) Return Store objects filtered by the vat_id column
 * @method array findByAddressId(int $address_id) Return Store objects filtered by the address_id column
 * @method array findByBillRegAddress(int $bill_reg_address) Return Store objects filtered by the bill_reg_address column
 * @method array findByBillingAddressId(int $billing_address_id) Return Store objects filtered by the billing_address_id column
 * @method array findByTelephone(string $telephone) Return Store objects filtered by the telephone column
 * @method array findByFax(string $fax) Return Store objects filtered by the fax column
 * @method array findByEmail(string $email) Return Store objects filtered by the email column
 * @method array findByDomain(string $domain) Return Store objects filtered by the domain column
 * @method array findByRealm(string $realm) Return Store objects filtered by the realm column
 * @method array findByHost(string $host) Return Store objects filtered by the host column
 * @method array findByHostname(string $hostname) Return Store objects filtered by the hostname column
 * @method array findByWebsite(string $website) Return Store objects filtered by the website column
 * @method array findByLogo(string $logo) Return Store objects filtered by the logo column
 * @method array findByCurrencyId(string $currency_id) Return Store objects filtered by the currency_id column
 * @method array findByTaxIncluded(int $tax_included) Return Store objects filtered by the tax_included column
 * @method array findByDefaultCategoryId(int $default_category_id) Return Store objects filtered by the default_category_id column
 * @method array findByLoading(string $loading) Return Store objects filtered by the loading column
 * @method array findByTemplateMinified(string $template_minified) Return Store objects filtered by the template_minified column
 * @method array findByKey(string $key) Return Store objects filtered by the key column
 * @method array findByTestcode(string $testcode) Return Store objects filtered by the testcode column
 * @method array findByActive(boolean $active) Return Store objects filtered by the active column
 * @method array findBySuspended(boolean $suspended) Return Store objects filtered by the suspended column
 * @method array findByStatus(int $status) Return Store objects filtered by the status column
 * @method array findByCreatedAt(string $created_at) Return Store objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return Store objects filtered by the updated_at column
 * @method array findByDeletedAt(string $deleted_at) Return Store objects filtered by the deleted_at column
 * @method array findByPlanId(int $plan_id) Return Store objects filtered by the plan_id column
 * @method array findByExpiresAt(string $expires_at) Return Store objects filtered by the expires_at column
 * @method array findByAffiliateId(int $affiliate_id) Return Store objects filtered by the affiliate_id column
 * @method array findByOauthToken(string $oauth_token) Return Store objects filtered by the oauth_token column
 * @method array findByYearEnd(boolean $year_end) Return Store objects filtered by the year_end column
 * @method array findByCountryId(string $country_id) Return Store objects filtered by the country_id column
 */
abstract class BaseStoreQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStoreQuery object.
     *
     * @param string $dbName     The dabase name
     * @param string $modelName  The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'dzangocart';
        }
        if (null === $modelName) {
            $modelName = 'Dzangocart\\Bundle\\CoreBundle\\Model\\Store';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StoreQuery object.
     *
     * @param string              $modelAlias The alias of a model in the query
     * @param StoreQuery|Criteria $criteria   Optional Criteria to build the query from
     *
     * @return StoreQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StoreQuery) {
            return $criteria;
        }
        $query = new StoreQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed     $key Primary key to use for the query
     * @param PropelPDO $con an optional connection object
     *
     * @return Store|Store[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StorePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param mixed     $key Primary key to use for the query
     * @param PropelPDO $con A connection object
     *
     * @return Store           A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed     $key Primary key to use for the query
     * @param PropelPDO $con A connection object
     *
     * @return Store           A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `owner_id`, `name`, `type_id`, `rcs`, `siren`, `naf`, `vat_id`, `address_id`, `bill_reg_address`, `billing_address_id`, `telephone`, `fax`, `email`, `domain`, `realm`, `host`, `hostname`, `website`, `logo`, `currency_id`, `tax_included`, `default_category_id`, `loading`, `template_minified`, `key`, `testcode`, `active`, `suspended`, `status`, `created_at`, `updated_at`, `deleted_at`, `plan_id`, `expires_at`, `affiliate_id`, `oauth_token`, `year_end`, `country_id` FROM `store` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Store();
            $obj->hydrate($row);
            StorePeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed     $key Primary key to use for the query
     * @param PropelPDO $con A connection object
     *
     * @return Store|Store[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param array     $keys Primary keys to use for the query
     * @param PropelPDO $con  an optional connection object
     *
     * @return PropelObjectCollection|Store[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param mixed $key Primary key to use for the query
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(StorePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array $keys The list of primary key to use for the query
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(StorePeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param mixed  $id         The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StorePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StorePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the owner_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOwnerId(1234); // WHERE owner_id = 1234
     * $query->filterByOwnerId(array(12, 34)); // WHERE owner_id IN (12, 34)
     * $query->filterByOwnerId(array('min' => 12)); // WHERE owner_id >= 12
     * $query->filterByOwnerId(array('max' => 12)); // WHERE owner_id <= 12
     * </code>
     *
     * @param mixed  $ownerId    The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByOwnerId($ownerId = null, $comparison = null)
    {
        if (is_array($ownerId)) {
            $useMinMax = false;
            if (isset($ownerId['min'])) {
                $this->addUsingAlias(StorePeer::OWNER_ID, $ownerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ownerId['max'])) {
                $this->addUsingAlias(StorePeer::OWNER_ID, $ownerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::OWNER_ID, $ownerId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param string $name       The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeId(1234); // WHERE type_id = 1234
     * $query->filterByTypeId(array(12, 34)); // WHERE type_id IN (12, 34)
     * $query->filterByTypeId(array('min' => 12)); // WHERE type_id >= 12
     * $query->filterByTypeId(array('max' => 12)); // WHERE type_id <= 12
     * </code>
     *
     * @param mixed  $typeId     The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(StorePeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(StorePeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the rcs column
     *
     * Example usage:
     * <code>
     * $query->filterByRcs('fooValue');   // WHERE rcs = 'fooValue'
     * $query->filterByRcs('%fooValue%'); // WHERE rcs LIKE '%fooValue%'
     * </code>
     *
     * @param string $rcs        The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByRcs($rcs = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rcs)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rcs)) {
                $rcs = str_replace('*', '%', $rcs);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::RCS, $rcs, $comparison);
    }

    /**
     * Filter the query on the siren column
     *
     * Example usage:
     * <code>
     * $query->filterBySiren('fooValue');   // WHERE siren = 'fooValue'
     * $query->filterBySiren('%fooValue%'); // WHERE siren LIKE '%fooValue%'
     * </code>
     *
     * @param string $siren      The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterBySiren($siren = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($siren)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $siren)) {
                $siren = str_replace('*', '%', $siren);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::SIREN, $siren, $comparison);
    }

    /**
     * Filter the query on the naf column
     *
     * Example usage:
     * <code>
     * $query->filterByNaf('fooValue');   // WHERE naf = 'fooValue'
     * $query->filterByNaf('%fooValue%'); // WHERE naf LIKE '%fooValue%'
     * </code>
     *
     * @param string $naf        The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByNaf($naf = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($naf)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $naf)) {
                $naf = str_replace('*', '%', $naf);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::NAF, $naf, $comparison);
    }

    /**
     * Filter the query on the vat_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVatId('fooValue');   // WHERE vat_id = 'fooValue'
     * $query->filterByVatId('%fooValue%'); // WHERE vat_id LIKE '%fooValue%'
     * </code>
     *
     * @param string $vatId      The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByVatId($vatId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($vatId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $vatId)) {
                $vatId = str_replace('*', '%', $vatId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::VAT_ID, $vatId, $comparison);
    }

    /**
     * Filter the query on the address_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAddressId(1234); // WHERE address_id = 1234
     * $query->filterByAddressId(array(12, 34)); // WHERE address_id IN (12, 34)
     * $query->filterByAddressId(array('min' => 12)); // WHERE address_id >= 12
     * $query->filterByAddressId(array('max' => 12)); // WHERE address_id <= 12
     * </code>
     *
     * @param mixed  $addressId  The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByAddressId($addressId = null, $comparison = null)
    {
        if (is_array($addressId)) {
            $useMinMax = false;
            if (isset($addressId['min'])) {
                $this->addUsingAlias(StorePeer::ADDRESS_ID, $addressId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($addressId['max'])) {
                $this->addUsingAlias(StorePeer::ADDRESS_ID, $addressId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::ADDRESS_ID, $addressId, $comparison);
    }

    /**
     * Filter the query on the bill_reg_address column
     *
     * Example usage:
     * <code>
     * $query->filterByBillRegAddress(1234); // WHERE bill_reg_address = 1234
     * $query->filterByBillRegAddress(array(12, 34)); // WHERE bill_reg_address IN (12, 34)
     * $query->filterByBillRegAddress(array('min' => 12)); // WHERE bill_reg_address >= 12
     * $query->filterByBillRegAddress(array('max' => 12)); // WHERE bill_reg_address <= 12
     * </code>
     *
     * @param mixed  $billRegAddress The value to use as filter.
     *                               Use scalar values for equality.
     *                               Use array values for in_array() equivalent.
     *                               Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison     Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByBillRegAddress($billRegAddress = null, $comparison = null)
    {
        if (is_array($billRegAddress)) {
            $useMinMax = false;
            if (isset($billRegAddress['min'])) {
                $this->addUsingAlias(StorePeer::BILL_REG_ADDRESS, $billRegAddress['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($billRegAddress['max'])) {
                $this->addUsingAlias(StorePeer::BILL_REG_ADDRESS, $billRegAddress['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::BILL_REG_ADDRESS, $billRegAddress, $comparison);
    }

    /**
     * Filter the query on the billing_address_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBillingAddressId(1234); // WHERE billing_address_id = 1234
     * $query->filterByBillingAddressId(array(12, 34)); // WHERE billing_address_id IN (12, 34)
     * $query->filterByBillingAddressId(array('min' => 12)); // WHERE billing_address_id >= 12
     * $query->filterByBillingAddressId(array('max' => 12)); // WHERE billing_address_id <= 12
     * </code>
     *
     * @param mixed  $billingAddressId The value to use as filter.
     *                                 Use scalar values for equality.
     *                                 Use array values for in_array() equivalent.
     *                                 Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison       Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByBillingAddressId($billingAddressId = null, $comparison = null)
    {
        if (is_array($billingAddressId)) {
            $useMinMax = false;
            if (isset($billingAddressId['min'])) {
                $this->addUsingAlias(StorePeer::BILLING_ADDRESS_ID, $billingAddressId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($billingAddressId['max'])) {
                $this->addUsingAlias(StorePeer::BILLING_ADDRESS_ID, $billingAddressId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::BILLING_ADDRESS_ID, $billingAddressId, $comparison);
    }

    /**
     * Filter the query on the telephone column
     *
     * Example usage:
     * <code>
     * $query->filterByTelephone('fooValue');   // WHERE telephone = 'fooValue'
     * $query->filterByTelephone('%fooValue%'); // WHERE telephone LIKE '%fooValue%'
     * </code>
     *
     * @param string $telephone  The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByTelephone($telephone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($telephone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $telephone)) {
                $telephone = str_replace('*', '%', $telephone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::TELEPHONE, $telephone, $comparison);
    }

    /**
     * Filter the query on the fax column
     *
     * Example usage:
     * <code>
     * $query->filterByFax('fooValue');   // WHERE fax = 'fooValue'
     * $query->filterByFax('%fooValue%'); // WHERE fax LIKE '%fooValue%'
     * </code>
     *
     * @param string $fax        The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByFax($fax = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fax)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fax)) {
                $fax = str_replace('*', '%', $fax);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::FAX, $fax, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param string $email      The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the domain column
     *
     * Example usage:
     * <code>
     * $query->filterByDomain('fooValue');   // WHERE domain = 'fooValue'
     * $query->filterByDomain('%fooValue%'); // WHERE domain LIKE '%fooValue%'
     * </code>
     *
     * @param string $domain     The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByDomain($domain = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($domain)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $domain)) {
                $domain = str_replace('*', '%', $domain);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::DOMAIN, $domain, $comparison);
    }

    /**
     * Filter the query on the realm column
     *
     * Example usage:
     * <code>
     * $query->filterByRealm('fooValue');   // WHERE realm = 'fooValue'
     * $query->filterByRealm('%fooValue%'); // WHERE realm LIKE '%fooValue%'
     * </code>
     *
     * @param string $realm      The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByRealm($realm = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($realm)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $realm)) {
                $realm = str_replace('*', '%', $realm);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::REALM, $realm, $comparison);
    }

    /**
     * Filter the query on the host column
     *
     * Example usage:
     * <code>
     * $query->filterByHost('fooValue');   // WHERE host = 'fooValue'
     * $query->filterByHost('%fooValue%'); // WHERE host LIKE '%fooValue%'
     * </code>
     *
     * @param string $host       The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByHost($host = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($host)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $host)) {
                $host = str_replace('*', '%', $host);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::HOST, $host, $comparison);
    }

    /**
     * Filter the query on the hostname column
     *
     * Example usage:
     * <code>
     * $query->filterByHostname('fooValue');   // WHERE hostname = 'fooValue'
     * $query->filterByHostname('%fooValue%'); // WHERE hostname LIKE '%fooValue%'
     * </code>
     *
     * @param string $hostname   The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByHostname($hostname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hostname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hostname)) {
                $hostname = str_replace('*', '%', $hostname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::HOSTNAME, $hostname, $comparison);
    }

    /**
     * Filter the query on the website column
     *
     * Example usage:
     * <code>
     * $query->filterByWebsite('fooValue');   // WHERE website = 'fooValue'
     * $query->filterByWebsite('%fooValue%'); // WHERE website LIKE '%fooValue%'
     * </code>
     *
     * @param string $website    The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByWebsite($website = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($website)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $website)) {
                $website = str_replace('*', '%', $website);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::WEBSITE, $website, $comparison);
    }

    /**
     * Filter the query on the logo column
     *
     * Example usage:
     * <code>
     * $query->filterByLogo('fooValue');   // WHERE logo = 'fooValue'
     * $query->filterByLogo('%fooValue%'); // WHERE logo LIKE '%fooValue%'
     * </code>
     *
     * @param string $logo       The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByLogo($logo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($logo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $logo)) {
                $logo = str_replace('*', '%', $logo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::LOGO, $logo, $comparison);
    }

    /**
     * Filter the query on the currency_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrencyId('fooValue');   // WHERE currency_id = 'fooValue'
     * $query->filterByCurrencyId('%fooValue%'); // WHERE currency_id LIKE '%fooValue%'
     * </code>
     *
     * @param string $currencyId The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByCurrencyId($currencyId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($currencyId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $currencyId)) {
                $currencyId = str_replace('*', '%', $currencyId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::CURRENCY_ID, $currencyId, $comparison);
    }

    /**
     * Filter the query on the tax_included column
     *
     * Example usage:
     * <code>
     * $query->filterByTaxIncluded(1234); // WHERE tax_included = 1234
     * $query->filterByTaxIncluded(array(12, 34)); // WHERE tax_included IN (12, 34)
     * $query->filterByTaxIncluded(array('min' => 12)); // WHERE tax_included >= 12
     * $query->filterByTaxIncluded(array('max' => 12)); // WHERE tax_included <= 12
     * </code>
     *
     * @param mixed  $taxIncluded The value to use as filter.
     *                            Use scalar values for equality.
     *                            Use array values for in_array() equivalent.
     *                            Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison  Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByTaxIncluded($taxIncluded = null, $comparison = null)
    {
        if (is_array($taxIncluded)) {
            $useMinMax = false;
            if (isset($taxIncluded['min'])) {
                $this->addUsingAlias(StorePeer::TAX_INCLUDED, $taxIncluded['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($taxIncluded['max'])) {
                $this->addUsingAlias(StorePeer::TAX_INCLUDED, $taxIncluded['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::TAX_INCLUDED, $taxIncluded, $comparison);
    }

    /**
     * Filter the query on the default_category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDefaultCategoryId(1234); // WHERE default_category_id = 1234
     * $query->filterByDefaultCategoryId(array(12, 34)); // WHERE default_category_id IN (12, 34)
     * $query->filterByDefaultCategoryId(array('min' => 12)); // WHERE default_category_id >= 12
     * $query->filterByDefaultCategoryId(array('max' => 12)); // WHERE default_category_id <= 12
     * </code>
     *
     * @param mixed  $defaultCategoryId The value to use as filter.
     *                                  Use scalar values for equality.
     *                                  Use array values for in_array() equivalent.
     *                                  Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison        Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByDefaultCategoryId($defaultCategoryId = null, $comparison = null)
    {
        if (is_array($defaultCategoryId)) {
            $useMinMax = false;
            if (isset($defaultCategoryId['min'])) {
                $this->addUsingAlias(StorePeer::DEFAULT_CATEGORY_ID, $defaultCategoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($defaultCategoryId['max'])) {
                $this->addUsingAlias(StorePeer::DEFAULT_CATEGORY_ID, $defaultCategoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::DEFAULT_CATEGORY_ID, $defaultCategoryId, $comparison);
    }

    /**
     * Filter the query on the loading column
     *
     * Example usage:
     * <code>
     * $query->filterByLoading('fooValue');   // WHERE loading = 'fooValue'
     * $query->filterByLoading('%fooValue%'); // WHERE loading LIKE '%fooValue%'
     * </code>
     *
     * @param string $loading    The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByLoading($loading = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($loading)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $loading)) {
                $loading = str_replace('*', '%', $loading);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::LOADING, $loading, $comparison);
    }

    /**
     * Filter the query on the template_minified column
     *
     * Example usage:
     * <code>
     * $query->filterByTemplateMinified('fooValue');   // WHERE template_minified = 'fooValue'
     * $query->filterByTemplateMinified('%fooValue%'); // WHERE template_minified LIKE '%fooValue%'
     * </code>
     *
     * @param string $templateMinified The value to use as filter.
     *                                 Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison       Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByTemplateMinified($templateMinified = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($templateMinified)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $templateMinified)) {
                $templateMinified = str_replace('*', '%', $templateMinified);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::TEMPLATE_MINIFIED, $templateMinified, $comparison);
    }

    /**
     * Filter the query on the key column
     *
     * Example usage:
     * <code>
     * $query->filterByKey('fooValue');   // WHERE key = 'fooValue'
     * $query->filterByKey('%fooValue%'); // WHERE key LIKE '%fooValue%'
     * </code>
     *
     * @param string $key        The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByKey($key = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($key)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $key)) {
                $key = str_replace('*', '%', $key);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::KEY, $key, $comparison);
    }

    /**
     * Filter the query on the testcode column
     *
     * Example usage:
     * <code>
     * $query->filterByTestcode('fooValue');   // WHERE testcode = 'fooValue'
     * $query->filterByTestcode('%fooValue%'); // WHERE testcode LIKE '%fooValue%'
     * </code>
     *
     * @param string $testcode   The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByTestcode($testcode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($testcode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $testcode)) {
                $testcode = str_replace('*', '%', $testcode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::TESTCODE, $testcode, $comparison);
    }

    /**
     * Filter the query on the active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(true); // WHERE active = true
     * $query->filterByActive('yes'); // WHERE active = true
     * </code>
     *
     * @param boolean|string $active     The value to use as filter.
     *                                   Non-boolean arguments are converted using the following rules:
     *                                   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                                   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *                                   Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string         $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_string($active)) {
            $active = in_array(strtolower($active), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(StorePeer::ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the suspended column
     *
     * Example usage:
     * <code>
     * $query->filterBySuspended(true); // WHERE suspended = true
     * $query->filterBySuspended('yes'); // WHERE suspended = true
     * </code>
     *
     * @param boolean|string $suspended  The value to use as filter.
     *                                   Non-boolean arguments are converted using the following rules:
     *                                   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                                   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *                                   Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string         $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterBySuspended($suspended = null, $comparison = null)
    {
        if (is_string($suspended)) {
            $suspended = in_array(strtolower($suspended), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(StorePeer::SUSPENDED, $suspended, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status >= 12
     * $query->filterByStatus(array('max' => 12)); // WHERE status <= 12
     * </code>
     *
     * @param mixed  $status     The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(StorePeer::STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(StorePeer::STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at < '2011-03-13'
     * </code>
     *
     * @param mixed  $createdAt  The value to use as filter.
     *                           Values can be integers (unix timestamps), DateTime objects, or strings.
     *                           Empty strings are treated as NULL.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(StorePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(StorePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at < '2011-03-13'
     * </code>
     *
     * @param mixed  $updatedAt  The value to use as filter.
     *                           Values can be integers (unix timestamps), DateTime objects, or strings.
     *                           Empty strings are treated as NULL.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(StorePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(StorePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the deleted_at column
     *
     * Example usage:
     * <code>
     * $query->filterByDeletedAt('2011-03-14'); // WHERE deleted_at = '2011-03-14'
     * $query->filterByDeletedAt('now'); // WHERE deleted_at = '2011-03-14'
     * $query->filterByDeletedAt(array('max' => 'yesterday')); // WHERE deleted_at < '2011-03-13'
     * </code>
     *
     * @param mixed  $deletedAt  The value to use as filter.
     *                           Values can be integers (unix timestamps), DateTime objects, or strings.
     *                           Empty strings are treated as NULL.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByDeletedAt($deletedAt = null, $comparison = null)
    {
        if (is_array($deletedAt)) {
            $useMinMax = false;
            if (isset($deletedAt['min'])) {
                $this->addUsingAlias(StorePeer::DELETED_AT, $deletedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deletedAt['max'])) {
                $this->addUsingAlias(StorePeer::DELETED_AT, $deletedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::DELETED_AT, $deletedAt, $comparison);
    }

    /**
     * Filter the query on the plan_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlanId(1234); // WHERE plan_id = 1234
     * $query->filterByPlanId(array(12, 34)); // WHERE plan_id IN (12, 34)
     * $query->filterByPlanId(array('min' => 12)); // WHERE plan_id >= 12
     * $query->filterByPlanId(array('max' => 12)); // WHERE plan_id <= 12
     * </code>
     *
     * @param mixed  $planId     The value to use as filter.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByPlanId($planId = null, $comparison = null)
    {
        if (is_array($planId)) {
            $useMinMax = false;
            if (isset($planId['min'])) {
                $this->addUsingAlias(StorePeer::PLAN_ID, $planId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($planId['max'])) {
                $this->addUsingAlias(StorePeer::PLAN_ID, $planId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::PLAN_ID, $planId, $comparison);
    }

    /**
     * Filter the query on the expires_at column
     *
     * Example usage:
     * <code>
     * $query->filterByExpiresAt('2011-03-14'); // WHERE expires_at = '2011-03-14'
     * $query->filterByExpiresAt('now'); // WHERE expires_at = '2011-03-14'
     * $query->filterByExpiresAt(array('max' => 'yesterday')); // WHERE expires_at < '2011-03-13'
     * </code>
     *
     * @param mixed  $expiresAt  The value to use as filter.
     *                           Values can be integers (unix timestamps), DateTime objects, or strings.
     *                           Empty strings are treated as NULL.
     *                           Use scalar values for equality.
     *                           Use array values for in_array() equivalent.
     *                           Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByExpiresAt($expiresAt = null, $comparison = null)
    {
        if (is_array($expiresAt)) {
            $useMinMax = false;
            if (isset($expiresAt['min'])) {
                $this->addUsingAlias(StorePeer::EXPIRES_AT, $expiresAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expiresAt['max'])) {
                $this->addUsingAlias(StorePeer::EXPIRES_AT, $expiresAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::EXPIRES_AT, $expiresAt, $comparison);
    }

    /**
     * Filter the query on the affiliate_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAffiliateId(1234); // WHERE affiliate_id = 1234
     * $query->filterByAffiliateId(array(12, 34)); // WHERE affiliate_id IN (12, 34)
     * $query->filterByAffiliateId(array('min' => 12)); // WHERE affiliate_id >= 12
     * $query->filterByAffiliateId(array('max' => 12)); // WHERE affiliate_id <= 12
     * </code>
     *
     * @param mixed  $affiliateId The value to use as filter.
     *                            Use scalar values for equality.
     *                            Use array values for in_array() equivalent.
     *                            Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string $comparison  Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByAffiliateId($affiliateId = null, $comparison = null)
    {
        if (is_array($affiliateId)) {
            $useMinMax = false;
            if (isset($affiliateId['min'])) {
                $this->addUsingAlias(StorePeer::AFFILIATE_ID, $affiliateId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($affiliateId['max'])) {
                $this->addUsingAlias(StorePeer::AFFILIATE_ID, $affiliateId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StorePeer::AFFILIATE_ID, $affiliateId, $comparison);
    }

    /**
     * Filter the query on the oauth_token column
     *
     * Example usage:
     * <code>
     * $query->filterByOauthToken('fooValue');   // WHERE oauth_token = 'fooValue'
     * $query->filterByOauthToken('%fooValue%'); // WHERE oauth_token LIKE '%fooValue%'
     * </code>
     *
     * @param string $oauthToken The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByOauthToken($oauthToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($oauthToken)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $oauthToken)) {
                $oauthToken = str_replace('*', '%', $oauthToken);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::OAUTH_TOKEN, $oauthToken, $comparison);
    }

    /**
     * Filter the query on the year_end column
     *
     * Example usage:
     * <code>
     * $query->filterByYearEnd(true); // WHERE year_end = true
     * $query->filterByYearEnd('yes'); // WHERE year_end = true
     * </code>
     *
     * @param boolean|string $yearEnd    The value to use as filter.
     *                                   Non-boolean arguments are converted using the following rules:
     *                                   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                                   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *                                   Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string         $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByYearEnd($yearEnd = null, $comparison = null)
    {
        if (is_string($yearEnd)) {
            $yearEnd = in_array(strtolower($yearEnd), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(StorePeer::YEAR_END, $yearEnd, $comparison);
    }

    /**
     * Filter the query on the country_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCountryId('fooValue');   // WHERE country_id = 'fooValue'
     * $query->filterByCountryId('%fooValue%'); // WHERE country_id LIKE '%fooValue%'
     * </code>
     *
     * @param string $countryId  The value to use as filter.
     *                           Accepts wildcards (* and % trigger a LIKE)
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function filterByCountryId($countryId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($countryId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $countryId)) {
                $countryId = str_replace('*', '%', $countryId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StorePeer::COUNTRY_ID, $countryId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param Store $store Object to remove from the list of results
     *
     * @return StoreQuery The current query, for fluid interface
     */
    public function prune($store = null)
    {
        if ($store) {
            $this->addUsingAlias(StorePeer::ID, $store->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
