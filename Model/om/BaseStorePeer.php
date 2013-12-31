<?php

namespace Dzangocart\Bundle\CoreBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Dzangocart\Bundle\CoreBundle\Model\Store;
use Dzangocart\Bundle\CoreBundle\Model\StorePeer;
use Dzangocart\Bundle\CoreBundle\Model\map\StoreTableMap;

abstract class BaseStorePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'dzangocart';

    /** the table name for this class */
    const TABLE_NAME = 'store';

    /** the related Propel class for this table */
    const OM_CLASS = 'Dzangocart\\Bundle\\CoreBundle\\Model\\Store';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Dzangocart\\Bundle\\CoreBundle\\Model\\map\\StoreTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 39;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 39;

    /** the column name for the id field */
    const ID = 'store.id';

    /** the column name for the owner_id field */
    const OWNER_ID = 'store.owner_id';

    /** the column name for the name field */
    const NAME = 'store.name';

    /** the column name for the type_id field */
    const TYPE_ID = 'store.type_id';

    /** the column name for the rcs field */
    const RCS = 'store.rcs';

    /** the column name for the siren field */
    const SIREN = 'store.siren';

    /** the column name for the naf field */
    const NAF = 'store.naf';

    /** the column name for the vat_id field */
    const VAT_ID = 'store.vat_id';

    /** the column name for the address_id field */
    const ADDRESS_ID = 'store.address_id';

    /** the column name for the bill_reg_address field */
    const BILL_REG_ADDRESS = 'store.bill_reg_address';

    /** the column name for the billing_address_id field */
    const BILLING_ADDRESS_ID = 'store.billing_address_id';

    /** the column name for the telephone field */
    const TELEPHONE = 'store.telephone';

    /** the column name for the fax field */
    const FAX = 'store.fax';

    /** the column name for the email field */
    const EMAIL = 'store.email';

    /** the column name for the domain field */
    const DOMAIN = 'store.domain';

    /** the column name for the realm field */
    const REALM = 'store.realm';

    /** the column name for the host field */
    const HOST = 'store.host';

    /** the column name for the hostname field */
    const HOSTNAME = 'store.hostname';

    /** the column name for the website field */
    const WEBSITE = 'store.website';

    /** the column name for the logo field */
    const LOGO = 'store.logo';

    /** the column name for the currency_id field */
    const CURRENCY_ID = 'store.currency_id';

    /** the column name for the tax_included field */
    const TAX_INCLUDED = 'store.tax_included';

    /** the column name for the default_category_id field */
    const DEFAULT_CATEGORY_ID = 'store.default_category_id';

    /** the column name for the loading field */
    const LOADING = 'store.loading';

    /** the column name for the template_minified field */
    const TEMPLATE_MINIFIED = 'store.template_minified';

    /** the column name for the key field */
    const KEY = 'store.key';

    /** the column name for the testcode field */
    const TESTCODE = 'store.testcode';

    /** the column name for the active field */
    const ACTIVE = 'store.active';

    /** the column name for the suspended field */
    const SUSPENDED = 'store.suspended';

    /** the column name for the status field */
    const STATUS = 'store.status';

    /** the column name for the created_at field */
    const CREATED_AT = 'store.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'store.updated_at';

    /** the column name for the deleted_at field */
    const DELETED_AT = 'store.deleted_at';

    /** the column name for the plan_id field */
    const PLAN_ID = 'store.plan_id';

    /** the column name for the expires_at field */
    const EXPIRES_AT = 'store.expires_at';

    /** the column name for the affiliate_id field */
    const AFFILIATE_ID = 'store.affiliate_id';

    /** the column name for the oauth_token field */
    const OAUTH_TOKEN = 'store.oauth_token';

    /** the column name for the year_end field */
    const YEAR_END = 'store.year_end';

    /** the column name for the country_id field */
    const COUNTRY_ID = 'store.country_id';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Store objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Store[]
     */
    public static $instances = array();

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. StorePeer::$fieldNames[StorePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'OwnerId', 'Name', 'TypeId', 'Rcs', 'Siren', 'Naf', 'VatId', 'AddressId', 'BillRegAddress', 'BillingAddressId', 'Telephone', 'Fax', 'Email', 'Domain', 'Realm', 'Host', 'Hostname', 'Website', 'Logo', 'CurrencyId', 'TaxIncluded', 'DefaultCategoryId', 'Loading', 'TemplateMinified', 'Key', 'Testcode', 'Active', 'Suspended', 'Status', 'CreatedAt', 'UpdatedAt', 'DeletedAt', 'PlanId', 'ExpiresAt', 'AffiliateId', 'OauthToken', 'YearEnd', 'CountryId', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'ownerId', 'name', 'typeId', 'rcs', 'siren', 'naf', 'vatId', 'addressId', 'billRegAddress', 'billingAddressId', 'telephone', 'fax', 'email', 'domain', 'realm', 'host', 'hostname', 'website', 'logo', 'currencyId', 'taxIncluded', 'defaultCategoryId', 'loading', 'templateMinified', 'key', 'testcode', 'active', 'suspended', 'status', 'createdAt', 'updatedAt', 'deletedAt', 'planId', 'expiresAt', 'affiliateId', 'oauthToken', 'yearEnd', 'countryId', ),
        BasePeer::TYPE_COLNAME => array (StorePeer::ID, StorePeer::OWNER_ID, StorePeer::NAME, StorePeer::TYPE_ID, StorePeer::RCS, StorePeer::SIREN, StorePeer::NAF, StorePeer::VAT_ID, StorePeer::ADDRESS_ID, StorePeer::BILL_REG_ADDRESS, StorePeer::BILLING_ADDRESS_ID, StorePeer::TELEPHONE, StorePeer::FAX, StorePeer::EMAIL, StorePeer::DOMAIN, StorePeer::REALM, StorePeer::HOST, StorePeer::HOSTNAME, StorePeer::WEBSITE, StorePeer::LOGO, StorePeer::CURRENCY_ID, StorePeer::TAX_INCLUDED, StorePeer::DEFAULT_CATEGORY_ID, StorePeer::LOADING, StorePeer::TEMPLATE_MINIFIED, StorePeer::KEY, StorePeer::TESTCODE, StorePeer::ACTIVE, StorePeer::SUSPENDED, StorePeer::STATUS, StorePeer::CREATED_AT, StorePeer::UPDATED_AT, StorePeer::DELETED_AT, StorePeer::PLAN_ID, StorePeer::EXPIRES_AT, StorePeer::AFFILIATE_ID, StorePeer::OAUTH_TOKEN, StorePeer::YEAR_END, StorePeer::COUNTRY_ID, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'OWNER_ID', 'NAME', 'TYPE_ID', 'RCS', 'SIREN', 'NAF', 'VAT_ID', 'ADDRESS_ID', 'BILL_REG_ADDRESS', 'BILLING_ADDRESS_ID', 'TELEPHONE', 'FAX', 'EMAIL', 'DOMAIN', 'REALM', 'HOST', 'HOSTNAME', 'WEBSITE', 'LOGO', 'CURRENCY_ID', 'TAX_INCLUDED', 'DEFAULT_CATEGORY_ID', 'LOADING', 'TEMPLATE_MINIFIED', 'KEY', 'TESTCODE', 'ACTIVE', 'SUSPENDED', 'STATUS', 'CREATED_AT', 'UPDATED_AT', 'DELETED_AT', 'PLAN_ID', 'EXPIRES_AT', 'AFFILIATE_ID', 'OAUTH_TOKEN', 'YEAR_END', 'COUNTRY_ID', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'owner_id', 'name', 'type_id', 'rcs', 'siren', 'naf', 'vat_id', 'address_id', 'bill_reg_address', 'billing_address_id', 'telephone', 'fax', 'email', 'domain', 'realm', 'host', 'hostname', 'website', 'logo', 'currency_id', 'tax_included', 'default_category_id', 'loading', 'template_minified', 'key', 'testcode', 'active', 'suspended', 'status', 'created_at', 'updated_at', 'deleted_at', 'plan_id', 'expires_at', 'affiliate_id', 'oauth_token', 'year_end', 'country_id', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. StorePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'OwnerId' => 1, 'Name' => 2, 'TypeId' => 3, 'Rcs' => 4, 'Siren' => 5, 'Naf' => 6, 'VatId' => 7, 'AddressId' => 8, 'BillRegAddress' => 9, 'BillingAddressId' => 10, 'Telephone' => 11, 'Fax' => 12, 'Email' => 13, 'Domain' => 14, 'Realm' => 15, 'Host' => 16, 'Hostname' => 17, 'Website' => 18, 'Logo' => 19, 'CurrencyId' => 20, 'TaxIncluded' => 21, 'DefaultCategoryId' => 22, 'Loading' => 23, 'TemplateMinified' => 24, 'Key' => 25, 'Testcode' => 26, 'Active' => 27, 'Suspended' => 28, 'Status' => 29, 'CreatedAt' => 30, 'UpdatedAt' => 31, 'DeletedAt' => 32, 'PlanId' => 33, 'ExpiresAt' => 34, 'AffiliateId' => 35, 'OauthToken' => 36, 'YearEnd' => 37, 'CountryId' => 38, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'ownerId' => 1, 'name' => 2, 'typeId' => 3, 'rcs' => 4, 'siren' => 5, 'naf' => 6, 'vatId' => 7, 'addressId' => 8, 'billRegAddress' => 9, 'billingAddressId' => 10, 'telephone' => 11, 'fax' => 12, 'email' => 13, 'domain' => 14, 'realm' => 15, 'host' => 16, 'hostname' => 17, 'website' => 18, 'logo' => 19, 'currencyId' => 20, 'taxIncluded' => 21, 'defaultCategoryId' => 22, 'loading' => 23, 'templateMinified' => 24, 'key' => 25, 'testcode' => 26, 'active' => 27, 'suspended' => 28, 'status' => 29, 'createdAt' => 30, 'updatedAt' => 31, 'deletedAt' => 32, 'planId' => 33, 'expiresAt' => 34, 'affiliateId' => 35, 'oauthToken' => 36, 'yearEnd' => 37, 'countryId' => 38, ),
        BasePeer::TYPE_COLNAME => array (StorePeer::ID => 0, StorePeer::OWNER_ID => 1, StorePeer::NAME => 2, StorePeer::TYPE_ID => 3, StorePeer::RCS => 4, StorePeer::SIREN => 5, StorePeer::NAF => 6, StorePeer::VAT_ID => 7, StorePeer::ADDRESS_ID => 8, StorePeer::BILL_REG_ADDRESS => 9, StorePeer::BILLING_ADDRESS_ID => 10, StorePeer::TELEPHONE => 11, StorePeer::FAX => 12, StorePeer::EMAIL => 13, StorePeer::DOMAIN => 14, StorePeer::REALM => 15, StorePeer::HOST => 16, StorePeer::HOSTNAME => 17, StorePeer::WEBSITE => 18, StorePeer::LOGO => 19, StorePeer::CURRENCY_ID => 20, StorePeer::TAX_INCLUDED => 21, StorePeer::DEFAULT_CATEGORY_ID => 22, StorePeer::LOADING => 23, StorePeer::TEMPLATE_MINIFIED => 24, StorePeer::KEY => 25, StorePeer::TESTCODE => 26, StorePeer::ACTIVE => 27, StorePeer::SUSPENDED => 28, StorePeer::STATUS => 29, StorePeer::CREATED_AT => 30, StorePeer::UPDATED_AT => 31, StorePeer::DELETED_AT => 32, StorePeer::PLAN_ID => 33, StorePeer::EXPIRES_AT => 34, StorePeer::AFFILIATE_ID => 35, StorePeer::OAUTH_TOKEN => 36, StorePeer::YEAR_END => 37, StorePeer::COUNTRY_ID => 38, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'OWNER_ID' => 1, 'NAME' => 2, 'TYPE_ID' => 3, 'RCS' => 4, 'SIREN' => 5, 'NAF' => 6, 'VAT_ID' => 7, 'ADDRESS_ID' => 8, 'BILL_REG_ADDRESS' => 9, 'BILLING_ADDRESS_ID' => 10, 'TELEPHONE' => 11, 'FAX' => 12, 'EMAIL' => 13, 'DOMAIN' => 14, 'REALM' => 15, 'HOST' => 16, 'HOSTNAME' => 17, 'WEBSITE' => 18, 'LOGO' => 19, 'CURRENCY_ID' => 20, 'TAX_INCLUDED' => 21, 'DEFAULT_CATEGORY_ID' => 22, 'LOADING' => 23, 'TEMPLATE_MINIFIED' => 24, 'KEY' => 25, 'TESTCODE' => 26, 'ACTIVE' => 27, 'SUSPENDED' => 28, 'STATUS' => 29, 'CREATED_AT' => 30, 'UPDATED_AT' => 31, 'DELETED_AT' => 32, 'PLAN_ID' => 33, 'EXPIRES_AT' => 34, 'AFFILIATE_ID' => 35, 'OAUTH_TOKEN' => 36, 'YEAR_END' => 37, 'COUNTRY_ID' => 38, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'owner_id' => 1, 'name' => 2, 'type_id' => 3, 'rcs' => 4, 'siren' => 5, 'naf' => 6, 'vat_id' => 7, 'address_id' => 8, 'bill_reg_address' => 9, 'billing_address_id' => 10, 'telephone' => 11, 'fax' => 12, 'email' => 13, 'domain' => 14, 'realm' => 15, 'host' => 16, 'hostname' => 17, 'website' => 18, 'logo' => 19, 'currency_id' => 20, 'tax_included' => 21, 'default_category_id' => 22, 'loading' => 23, 'template_minified' => 24, 'key' => 25, 'testcode' => 26, 'active' => 27, 'suspended' => 28, 'status' => 29, 'created_at' => 30, 'updated_at' => 31, 'deleted_at' => 32, 'plan_id' => 33, 'expires_at' => 34, 'affiliate_id' => 35, 'oauth_token' => 36, 'year_end' => 37, 'country_id' => 38, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param  string          $name     field name
     * @param  string          $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                                   BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param  string          $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = StorePeer::getFieldNames($toType);
        $key = isset(StorePeer::$fieldKeys[$fromType][$name]) ? StorePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(StorePeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param  string          $type The type of fieldnames to return:
     *                               One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, StorePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return StorePeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param  string $alias  The alias for the current table.
     * @param  string $column The column name for current table. (i.e. StorePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(StorePeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param  Criteria        $criteria object containing the columns to add.
     * @param  string          $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                                  rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(StorePeer::ID);
            $criteria->addSelectColumn(StorePeer::OWNER_ID);
            $criteria->addSelectColumn(StorePeer::NAME);
            $criteria->addSelectColumn(StorePeer::TYPE_ID);
            $criteria->addSelectColumn(StorePeer::RCS);
            $criteria->addSelectColumn(StorePeer::SIREN);
            $criteria->addSelectColumn(StorePeer::NAF);
            $criteria->addSelectColumn(StorePeer::VAT_ID);
            $criteria->addSelectColumn(StorePeer::ADDRESS_ID);
            $criteria->addSelectColumn(StorePeer::BILL_REG_ADDRESS);
            $criteria->addSelectColumn(StorePeer::BILLING_ADDRESS_ID);
            $criteria->addSelectColumn(StorePeer::TELEPHONE);
            $criteria->addSelectColumn(StorePeer::FAX);
            $criteria->addSelectColumn(StorePeer::EMAIL);
            $criteria->addSelectColumn(StorePeer::DOMAIN);
            $criteria->addSelectColumn(StorePeer::REALM);
            $criteria->addSelectColumn(StorePeer::HOST);
            $criteria->addSelectColumn(StorePeer::HOSTNAME);
            $criteria->addSelectColumn(StorePeer::WEBSITE);
            $criteria->addSelectColumn(StorePeer::LOGO);
            $criteria->addSelectColumn(StorePeer::CURRENCY_ID);
            $criteria->addSelectColumn(StorePeer::TAX_INCLUDED);
            $criteria->addSelectColumn(StorePeer::DEFAULT_CATEGORY_ID);
            $criteria->addSelectColumn(StorePeer::LOADING);
            $criteria->addSelectColumn(StorePeer::TEMPLATE_MINIFIED);
            $criteria->addSelectColumn(StorePeer::KEY);
            $criteria->addSelectColumn(StorePeer::TESTCODE);
            $criteria->addSelectColumn(StorePeer::ACTIVE);
            $criteria->addSelectColumn(StorePeer::SUSPENDED);
            $criteria->addSelectColumn(StorePeer::STATUS);
            $criteria->addSelectColumn(StorePeer::CREATED_AT);
            $criteria->addSelectColumn(StorePeer::UPDATED_AT);
            $criteria->addSelectColumn(StorePeer::DELETED_AT);
            $criteria->addSelectColumn(StorePeer::PLAN_ID);
            $criteria->addSelectColumn(StorePeer::EXPIRES_AT);
            $criteria->addSelectColumn(StorePeer::AFFILIATE_ID);
            $criteria->addSelectColumn(StorePeer::OAUTH_TOKEN);
            $criteria->addSelectColumn(StorePeer::YEAR_END);
            $criteria->addSelectColumn(StorePeer::COUNTRY_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.owner_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.type_id');
            $criteria->addSelectColumn($alias . '.rcs');
            $criteria->addSelectColumn($alias . '.siren');
            $criteria->addSelectColumn($alias . '.naf');
            $criteria->addSelectColumn($alias . '.vat_id');
            $criteria->addSelectColumn($alias . '.address_id');
            $criteria->addSelectColumn($alias . '.bill_reg_address');
            $criteria->addSelectColumn($alias . '.billing_address_id');
            $criteria->addSelectColumn($alias . '.telephone');
            $criteria->addSelectColumn($alias . '.fax');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.domain');
            $criteria->addSelectColumn($alias . '.realm');
            $criteria->addSelectColumn($alias . '.host');
            $criteria->addSelectColumn($alias . '.hostname');
            $criteria->addSelectColumn($alias . '.website');
            $criteria->addSelectColumn($alias . '.logo');
            $criteria->addSelectColumn($alias . '.currency_id');
            $criteria->addSelectColumn($alias . '.tax_included');
            $criteria->addSelectColumn($alias . '.default_category_id');
            $criteria->addSelectColumn($alias . '.loading');
            $criteria->addSelectColumn($alias . '.template_minified');
            $criteria->addSelectColumn($alias . '.key');
            $criteria->addSelectColumn($alias . '.testcode');
            $criteria->addSelectColumn($alias . '.active');
            $criteria->addSelectColumn($alias . '.suspended');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.deleted_at');
            $criteria->addSelectColumn($alias . '.plan_id');
            $criteria->addSelectColumn($alias . '.expires_at');
            $criteria->addSelectColumn($alias . '.affiliate_id');
            $criteria->addSelectColumn($alias . '.oauth_token');
            $criteria->addSelectColumn($alias . '.year_end');
            $criteria->addSelectColumn($alias . '.country_id');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param  Criteria  $criteria
     * @param  boolean   $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param  PropelPDO $con
     * @return int       Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(StorePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            StorePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(StorePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param  Criteria        $criteria object used to create the SELECT statement.
     * @param  PropelPDO       $con
     * @return Store
     * @throws PropelException Any exceptions caught during processing will be
     *                                  rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = StorePeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param  Criteria        $criteria The Criteria object used to build the SELECT statement.
     * @param  PropelPDO       $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *                                  rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return StorePeer::populateObjects(StorePeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param  Criteria        $criteria The Criteria object used to build the SELECT statement.
     * @param  PropelPDO       $con      The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *                                  rethrown wrapped into a PropelException.
     * @return PDOStatement    The executed PDOStatement object.
     *                                  @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            StorePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(StorePeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param Store  $obj A Store object.
     * @param string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            StorePeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A Store object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Store) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Store object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(StorePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param  string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Store  Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     *                    @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(StorePeer::$instances[$key])) {
                return StorePeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (StorePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        StorePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to store
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param  array  $row      PropelPDO resultset row.
     * @param  int    $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param  array $row      PropelPDO resultset row.
     * @param  int   $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {
        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = StorePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = StorePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = StorePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StorePeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param  array           $row      PropelPDO resultset row.
     * @param  int             $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *                                  rethrown wrapped into a PropelException.
     * @return array           (Store object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = StorePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = StorePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + StorePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StorePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            StorePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(StorePeer::DATABASE_NAME)->getTable(StorePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseStorePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseStorePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Dzangocart\Bundle\CoreBundle\Model\map\StoreTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return StorePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Store or Criteria object.
     *
     * @param  mixed           $values Criteria or Store object containing data that is used to create the INSERT statement.
     * @param  PropelPDO       $con    the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                                rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Store object
        }

        if ($criteria->containsKey(StorePeer::ID) && $criteria->keyContainsValue(StorePeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StorePeer::ID.')');
        }

        // Set the correct dbName
        $criteria->setDbName(StorePeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Store or Criteria object.
     *
     * @param  mixed           $values Criteria or Store object containing data that is used to create the UPDATE statement.
     * @param  PropelPDO       $con    The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *                                rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(StorePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(StorePeer::ID);
            $value = $criteria->remove(StorePeer::ID);
            if ($value) {
                $selectCriteria->add(StorePeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(StorePeer::TABLE_NAME);
            }

        } else { // $values is Store object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(StorePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the store table.
     *
     * @param  PropelPDO       $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(StorePeer::TABLE_NAME, $con, StorePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StorePeer::clearInstancePool();
            StorePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Store or Criteria object OR a primary key value.
     *
     * @param  mixed           $values Criteria or Store object or primary key or array of primary keys
     *                                 which is used to create the DELETE statement
     * @param  PropelPDO       $con    the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                                rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            StorePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Store) { // it's a model object
            // invalidate the cache for this single object
            StorePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StorePeer::DATABASE_NAME);
            $criteria->add(StorePeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                StorePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(StorePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            StorePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Store object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Store $obj  The object to validate.
     * @param mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(StorePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(StorePeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(StorePeer::DATABASE_NAME, StorePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param  int       $pk  the primary key.
     * @param  PropelPDO $con the connection to use
     * @return Store
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = StorePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(StorePeer::DATABASE_NAME);
        $criteria->add(StorePeer::ID, $pk);

        $v = StorePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param  array           $pks List of primary keys
     * @param  PropelPDO       $con the connection to use
     * @return Store[]
     * @throws PropelException Any exceptions caught during processing will be
     *                             rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(StorePeer::DATABASE_NAME);
            $criteria->add(StorePeer::ID, $pks, Criteria::IN);
            $objs = StorePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseStorePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseStorePeer::buildTableMap();
