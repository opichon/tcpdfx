<?php

namespace Dzangocart\Bundle\CoreBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelDateTime;
use \PropelException;
use \PropelPDO;
use Dzangocart\Bundle\CoreBundle\Model\Store;
use Dzangocart\Bundle\CoreBundle\Model\StorePeer;
use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

abstract class BaseStore extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Dzangocart\\Bundle\\CoreBundle\\Model\\StorePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        StorePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the owner_id field.
     * @var        int
     */
    protected $owner_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

    /**
     * The value for the rcs field.
     * @var        string
     */
    protected $rcs;

    /**
     * The value for the siren field.
     * @var        string
     */
    protected $siren;

    /**
     * The value for the naf field.
     * @var        string
     */
    protected $naf;

    /**
     * The value for the vat_id field.
     * @var        string
     */
    protected $vat_id;

    /**
     * The value for the address_id field.
     * @var        int
     */
    protected $address_id;

    /**
     * The value for the bill_reg_address field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $bill_reg_address;

    /**
     * The value for the billing_address_id field.
     * @var        int
     */
    protected $billing_address_id;

    /**
     * The value for the telephone field.
     * @var        string
     */
    protected $telephone;

    /**
     * The value for the fax field.
     * @var        string
     */
    protected $fax;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the domain field.
     * @var        string
     */
    protected $domain;

    /**
     * The value for the realm field.
     * @var        string
     */
    protected $realm;

    /**
     * The value for the host field.
     * @var        string
     */
    protected $host;

    /**
     * The value for the hostname field.
     * @var        string
     */
    protected $hostname;

    /**
     * The value for the website field.
     * @var        string
     */
    protected $website;

    /**
     * The value for the logo field.
     * @var        string
     */
    protected $logo;

    /**
     * The value for the currency_id field.
     * Note: this column has a database default value of: 'EUR'
     * @var        string
     */
    protected $currency_id;

    /**
     * The value for the tax_included field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $tax_included;

    /**
     * The value for the default_category_id field.
     * @var        int
     */
    protected $default_category_id;

    /**
     * The value for the loading field.
     * @var        string
     */
    protected $loading;

    /**
     * The value for the template_minified field.
     * @var        string
     */
    protected $template_minified;

    /**
     * The value for the key field.
     * @var        string
     */
    protected $key;

    /**
     * The value for the testcode field.
     * @var        string
     */
    protected $testcode;

    /**
     * The value for the active field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $active;

    /**
     * The value for the suspended field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $suspended;

    /**
     * The value for the status field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $status;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * The value for the deleted_at field.
     * @var        string
     */
    protected $deleted_at;

    /**
     * The value for the plan_id field.
     * @var        int
     */
    protected $plan_id;

    /**
     * The value for the expires_at field.
     * @var        string
     */
    protected $expires_at;

    /**
     * The value for the affiliate_id field.
     * @var        int
     */
    protected $affiliate_id;

    /**
     * The value for the oauth_token field.
     * @var        string
     */
    protected $oauth_token;

    /**
     * The value for the year_end field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $year_end;

    /**
     * The value for the country_id field.
     * Note: this column has a database default value of: 'FR'
     * @var        string
     */
    protected $country_id;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->bill_reg_address = 1;
        $this->currency_id = 'EUR';
        $this->tax_included = 0;
        $this->active = false;
        $this->suspended = false;
        $this->status = 0;
        $this->year_end = true;
        $this->country_id = 'FR';
    }

    /**
     * Initializes internal state of BaseStore object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [owner_id] column value.
     *
     * @return int
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [type_id] column value.
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Get the [rcs] column value.
     *
     * @return string
     */
    public function getRcs()
    {
        return $this->rcs;
    }

    /**
     * Get the [siren] column value.
     *
     * @return string
     */
    public function getSiren()
    {
        return $this->siren;
    }

    /**
     * Get the [naf] column value.
     *
     * @return string
     */
    public function getNaf()
    {
        return $this->naf;
    }

    /**
     * Get the [vat_id] column value.
     *
     * @return string
     */
    public function getVatId()
    {
        return $this->vat_id;
    }

    /**
     * Get the [address_id] column value.
     *
     * @return int
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     * Get the [bill_reg_address] column value.
     *
     * @return int
     */
    public function getBillRegAddress()
    {
        return $this->bill_reg_address;
    }

    /**
     * Get the [billing_address_id] column value.
     *
     * @return int
     */
    public function getBillingAddressId()
    {
        return $this->billing_address_id;
    }

    /**
     * Get the [telephone] column value.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Get the [fax] column value.
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [domain] column value.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Get the [realm] column value.
     *
     * @return string
     */
    public function getRealm()
    {
        return $this->realm;
    }

    /**
     * Get the [host] column value.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Get the [hostname] column value.
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Get the [website] column value.
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Get the [logo] column value.
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Get the [currency_id] column value.
     *
     * @return string
     */
    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    /**
     * Get the [tax_included] column value.
     *
     * @return int
     */
    public function getTaxIncluded()
    {
        return $this->tax_included;
    }

    /**
     * Get the [default_category_id] column value.
     *
     * @return int
     */
    public function getDefaultCategoryId()
    {
        return $this->default_category_id;
    }

    /**
     * Get the [loading] column value.
     *
     * @return string
     */
    public function getLoading()
    {
        return $this->loading;
    }

    /**
     * Get the [template_minified] column value.
     *
     * @return string
     */
    public function getTemplateMinified()
    {
        return $this->template_minified;
    }

    /**
     * Get the [key] column value.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the [testcode] column value.
     *
     * @return string
     */
    public function getTestcode()
    {
        return $this->testcode;
    }

    /**
     * Get the [active] column value.
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get the [suspended] column value.
     *
     * @return boolean
     */
    public function getSuspended()
    {
        return $this->suspended;
    }

    /**
     * Get the [status] column value.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param  string          $format The date/time format string (either date()-style or strftime()-style).
     *                                 If format is null, then the raw DateTime object will be returned.
     * @return mixed           Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = null)
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param  string          $format The date/time format string (either date()-style or strftime()-style).
     *                                 If format is null, then the raw DateTime object will be returned.
     * @return mixed           Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = null)
    {
        if ($this->updated_at === null) {
            return null;
        }

        if ($this->updated_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->updated_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [deleted_at] column value.
     *
     *
     * @param  string          $format The date/time format string (either date()-style or strftime()-style).
     *                                 If format is null, then the raw DateTime object will be returned.
     * @return mixed           Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDeletedAt($format = null)
    {
        if ($this->deleted_at === null) {
            return null;
        }

        if ($this->deleted_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->deleted_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->deleted_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [plan_id] column value.
     *
     * @return int
     */
    public function getPlanId()
    {
        return $this->plan_id;
    }

    /**
     * Get the [optionally formatted] temporal [expires_at] column value.
     *
     *
     * @param  string          $format The date/time format string (either date()-style or strftime()-style).
     *                                 If format is null, then the raw DateTime object will be returned.
     * @return mixed           Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getExpiresAt($format = null)
    {
        if ($this->expires_at === null) {
            return null;
        }

        if ($this->expires_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->expires_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->expires_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [affiliate_id] column value.
     *
     * @return int
     */
    public function getAffiliateId()
    {
        return $this->affiliate_id;
    }

    /**
     * Get the [oauth_token] column value.
     *
     * @return string
     */
    public function getOauthToken()
    {
        return $this->oauth_token;
    }

    /**
     * Get the [year_end] column value.
     *
     * @return boolean
     */
    public function getYearEnd()
    {
        return $this->year_end;
    }

    /**
     * Get the [country_id] column value.
     *
     * @return string
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = StorePeer::ID;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [owner_id] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setOwnerId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->owner_id !== $v) {
            $this->owner_id = $v;
            $this->modifiedColumns[] = StorePeer::OWNER_ID;
        }

        return $this;
    } // setOwnerId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = StorePeer::NAME;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [type_id] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = StorePeer::TYPE_ID;
        }

        return $this;
    } // setTypeId()

    /**
     * Set the value of [rcs] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setRcs($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->rcs !== $v) {
            $this->rcs = $v;
            $this->modifiedColumns[] = StorePeer::RCS;
        }

        return $this;
    } // setRcs()

    /**
     * Set the value of [siren] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setSiren($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->siren !== $v) {
            $this->siren = $v;
            $this->modifiedColumns[] = StorePeer::SIREN;
        }

        return $this;
    } // setSiren()

    /**
     * Set the value of [naf] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setNaf($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->naf !== $v) {
            $this->naf = $v;
            $this->modifiedColumns[] = StorePeer::NAF;
        }

        return $this;
    } // setNaf()

    /**
     * Set the value of [vat_id] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setVatId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->vat_id !== $v) {
            $this->vat_id = $v;
            $this->modifiedColumns[] = StorePeer::VAT_ID;
        }

        return $this;
    } // setVatId()

    /**
     * Set the value of [address_id] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setAddressId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->address_id !== $v) {
            $this->address_id = $v;
            $this->modifiedColumns[] = StorePeer::ADDRESS_ID;
        }

        return $this;
    } // setAddressId()

    /**
     * Set the value of [bill_reg_address] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setBillRegAddress($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->bill_reg_address !== $v) {
            $this->bill_reg_address = $v;
            $this->modifiedColumns[] = StorePeer::BILL_REG_ADDRESS;
        }

        return $this;
    } // setBillRegAddress()

    /**
     * Set the value of [billing_address_id] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setBillingAddressId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->billing_address_id !== $v) {
            $this->billing_address_id = $v;
            $this->modifiedColumns[] = StorePeer::BILLING_ADDRESS_ID;
        }

        return $this;
    } // setBillingAddressId()

    /**
     * Set the value of [telephone] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setTelephone($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->telephone !== $v) {
            $this->telephone = $v;
            $this->modifiedColumns[] = StorePeer::TELEPHONE;
        }

        return $this;
    } // setTelephone()

    /**
     * Set the value of [fax] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setFax($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->fax !== $v) {
            $this->fax = $v;
            $this->modifiedColumns[] = StorePeer::FAX;
        }

        return $this;
    } // setFax()

    /**
     * Set the value of [email] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[] = StorePeer::EMAIL;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [domain] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setDomain($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->domain !== $v) {
            $this->domain = $v;
            $this->modifiedColumns[] = StorePeer::DOMAIN;
        }

        return $this;
    } // setDomain()

    /**
     * Set the value of [realm] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setRealm($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->realm !== $v) {
            $this->realm = $v;
            $this->modifiedColumns[] = StorePeer::REALM;
        }

        return $this;
    } // setRealm()

    /**
     * Set the value of [host] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setHost($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->host !== $v) {
            $this->host = $v;
            $this->modifiedColumns[] = StorePeer::HOST;
        }

        return $this;
    } // setHost()

    /**
     * Set the value of [hostname] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setHostname($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->hostname !== $v) {
            $this->hostname = $v;
            $this->modifiedColumns[] = StorePeer::HOSTNAME;
        }

        return $this;
    } // setHostname()

    /**
     * Set the value of [website] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setWebsite($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->website !== $v) {
            $this->website = $v;
            $this->modifiedColumns[] = StorePeer::WEBSITE;
        }

        return $this;
    } // setWebsite()

    /**
     * Set the value of [logo] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setLogo($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->logo !== $v) {
            $this->logo = $v;
            $this->modifiedColumns[] = StorePeer::LOGO;
        }

        return $this;
    } // setLogo()

    /**
     * Set the value of [currency_id] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setCurrencyId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->currency_id !== $v) {
            $this->currency_id = $v;
            $this->modifiedColumns[] = StorePeer::CURRENCY_ID;
        }

        return $this;
    } // setCurrencyId()

    /**
     * Set the value of [tax_included] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setTaxIncluded($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->tax_included !== $v) {
            $this->tax_included = $v;
            $this->modifiedColumns[] = StorePeer::TAX_INCLUDED;
        }

        return $this;
    } // setTaxIncluded()

    /**
     * Set the value of [default_category_id] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setDefaultCategoryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->default_category_id !== $v) {
            $this->default_category_id = $v;
            $this->modifiedColumns[] = StorePeer::DEFAULT_CATEGORY_ID;
        }

        return $this;
    } // setDefaultCategoryId()

    /**
     * Set the value of [loading] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setLoading($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->loading !== $v) {
            $this->loading = $v;
            $this->modifiedColumns[] = StorePeer::LOADING;
        }

        return $this;
    } // setLoading()

    /**
     * Set the value of [template_minified] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setTemplateMinified($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->template_minified !== $v) {
            $this->template_minified = $v;
            $this->modifiedColumns[] = StorePeer::TEMPLATE_MINIFIED;
        }

        return $this;
    } // setTemplateMinified()

    /**
     * Set the value of [key] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setKey($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->key !== $v) {
            $this->key = $v;
            $this->modifiedColumns[] = StorePeer::KEY;
        }

        return $this;
    } // setKey()

    /**
     * Set the value of [testcode] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setTestcode($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->testcode !== $v) {
            $this->testcode = $v;
            $this->modifiedColumns[] = StorePeer::TESTCODE;
        }

        return $this;
    } // setTestcode()

    /**
     * Sets the value of the [active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return Store                  The current object (for fluent API support)
     */
    public function setActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->active !== $v) {
            $this->active = $v;
            $this->modifiedColumns[] = StorePeer::ACTIVE;
        }

        return $this;
    } // setActive()

    /**
     * Sets the value of the [suspended] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return Store                  The current object (for fluent API support)
     */
    public function setSuspended($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->suspended !== $v) {
            $this->suspended = $v;
            $this->modifiedColumns[] = StorePeer::SUSPENDED;
        }

        return $this;
    } // setSuspended()

    /**
     * Set the value of [status] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[] = StorePeer::STATUS;
        }

        return $this;
    } // setStatus()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or DateTime value.
     *                  Empty strings are treated as null.
     * @return Store The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = StorePeer::CREATED_AT;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or DateTime value.
     *                  Empty strings are treated as null.
     * @return Store The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = StorePeer::UPDATED_AT;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Sets the value of [deleted_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or DateTime value.
     *                  Empty strings are treated as null.
     * @return Store The current object (for fluent API support)
     */
    public function setDeletedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->deleted_at !== null || $dt !== null) {
            $currentDateAsString = ($this->deleted_at !== null && $tmpDt = new DateTime($this->deleted_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->deleted_at = $newDateAsString;
                $this->modifiedColumns[] = StorePeer::DELETED_AT;
            }
        } // if either are not null

        return $this;
    } // setDeletedAt()

    /**
     * Set the value of [plan_id] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setPlanId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->plan_id !== $v) {
            $this->plan_id = $v;
            $this->modifiedColumns[] = StorePeer::PLAN_ID;
        }

        return $this;
    } // setPlanId()

    /**
     * Sets the value of [expires_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or DateTime value.
     *                  Empty strings are treated as null.
     * @return Store The current object (for fluent API support)
     */
    public function setExpiresAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->expires_at !== null || $dt !== null) {
            $currentDateAsString = ($this->expires_at !== null && $tmpDt = new DateTime($this->expires_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->expires_at = $newDateAsString;
                $this->modifiedColumns[] = StorePeer::EXPIRES_AT;
            }
        } // if either are not null

        return $this;
    } // setExpiresAt()

    /**
     * Set the value of [affiliate_id] column.
     *
     * @param  int   $v new value
     * @return Store The current object (for fluent API support)
     */
    public function setAffiliateId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->affiliate_id !== $v) {
            $this->affiliate_id = $v;
            $this->modifiedColumns[] = StorePeer::AFFILIATE_ID;
        }

        return $this;
    } // setAffiliateId()

    /**
     * Set the value of [oauth_token] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setOauthToken($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->oauth_token !== $v) {
            $this->oauth_token = $v;
            $this->modifiedColumns[] = StorePeer::OAUTH_TOKEN;
        }

        return $this;
    } // setOauthToken()

    /**
     * Sets the value of the [year_end] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return Store                  The current object (for fluent API support)
     */
    public function setYearEnd($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->year_end !== $v) {
            $this->year_end = $v;
            $this->modifiedColumns[] = StorePeer::YEAR_END;
        }

        return $this;
    } // setYearEnd()

    /**
     * Set the value of [country_id] column.
     *
     * @param  string $v new value
     * @return Store  The current object (for fluent API support)
     */
    public function setCountryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->country_id !== $v) {
            $this->country_id = $v;
            $this->modifiedColumns[] = StorePeer::COUNTRY_ID;
        }

        return $this;
    } // setCountryId()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->bill_reg_address !== 1) {
                return false;
            }

            if ($this->currency_id !== 'EUR') {
                return false;
            }

            if ($this->tax_included !== 0) {
                return false;
            }

            if ($this->active !== false) {
                return false;
            }

            if ($this->suspended !== false) {
                return false;
            }

            if ($this->status !== 0) {
                return false;
            }

            if ($this->year_end !== true) {
                return false;
            }

            if ($this->country_id !== 'FR') {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param  array           $row       The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param  int             $startcol  0-based offset column which indicates which resultset column to start with.
     * @param  boolean         $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->owner_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->type_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->rcs = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->siren = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->naf = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->vat_id = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->address_id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->bill_reg_address = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->billing_address_id = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->telephone = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->fax = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->email = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->domain = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->realm = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
            $this->host = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
            $this->hostname = ($row[$startcol + 17] !== null) ? (string) $row[$startcol + 17] : null;
            $this->website = ($row[$startcol + 18] !== null) ? (string) $row[$startcol + 18] : null;
            $this->logo = ($row[$startcol + 19] !== null) ? (string) $row[$startcol + 19] : null;
            $this->currency_id = ($row[$startcol + 20] !== null) ? (string) $row[$startcol + 20] : null;
            $this->tax_included = ($row[$startcol + 21] !== null) ? (int) $row[$startcol + 21] : null;
            $this->default_category_id = ($row[$startcol + 22] !== null) ? (int) $row[$startcol + 22] : null;
            $this->loading = ($row[$startcol + 23] !== null) ? (string) $row[$startcol + 23] : null;
            $this->template_minified = ($row[$startcol + 24] !== null) ? (string) $row[$startcol + 24] : null;
            $this->key = ($row[$startcol + 25] !== null) ? (string) $row[$startcol + 25] : null;
            $this->testcode = ($row[$startcol + 26] !== null) ? (string) $row[$startcol + 26] : null;
            $this->active = ($row[$startcol + 27] !== null) ? (boolean) $row[$startcol + 27] : null;
            $this->suspended = ($row[$startcol + 28] !== null) ? (boolean) $row[$startcol + 28] : null;
            $this->status = ($row[$startcol + 29] !== null) ? (int) $row[$startcol + 29] : null;
            $this->created_at = ($row[$startcol + 30] !== null) ? (string) $row[$startcol + 30] : null;
            $this->updated_at = ($row[$startcol + 31] !== null) ? (string) $row[$startcol + 31] : null;
            $this->deleted_at = ($row[$startcol + 32] !== null) ? (string) $row[$startcol + 32] : null;
            $this->plan_id = ($row[$startcol + 33] !== null) ? (int) $row[$startcol + 33] : null;
            $this->expires_at = ($row[$startcol + 34] !== null) ? (string) $row[$startcol + 34] : null;
            $this->affiliate_id = ($row[$startcol + 35] !== null) ? (int) $row[$startcol + 35] : null;
            $this->oauth_token = ($row[$startcol + 36] !== null) ? (string) $row[$startcol + 36] : null;
            $this->year_end = ($row[$startcol + 37] !== null) ? (boolean) $row[$startcol + 37] : null;
            $this->country_id = ($row[$startcol + 38] !== null) ? (string) $row[$startcol + 38] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 39; // 39 = StorePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Store object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param  boolean         $deep (optional) Whether to also de-associated any related objects.
     * @param  PropelPDO       $con  (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = StorePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param  PropelPDO       $con
     * @return void
     * @throws PropelException
     * @throws Exception
     *                             @see        BaseObject::setDeleted()
     *                             @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = StoreQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param  PropelPDO       $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     *                             @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(StorePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                StorePeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param  PropelPDO       $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     *                             @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     *                         @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = StorePeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StorePeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StorePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(StorePeer::OWNER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`owner_id`';
        }
        if ($this->isColumnModified(StorePeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(StorePeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`type_id`';
        }
        if ($this->isColumnModified(StorePeer::RCS)) {
            $modifiedColumns[':p' . $index++]  = '`rcs`';
        }
        if ($this->isColumnModified(StorePeer::SIREN)) {
            $modifiedColumns[':p' . $index++]  = '`siren`';
        }
        if ($this->isColumnModified(StorePeer::NAF)) {
            $modifiedColumns[':p' . $index++]  = '`naf`';
        }
        if ($this->isColumnModified(StorePeer::VAT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`vat_id`';
        }
        if ($this->isColumnModified(StorePeer::ADDRESS_ID)) {
            $modifiedColumns[':p' . $index++]  = '`address_id`';
        }
        if ($this->isColumnModified(StorePeer::BILL_REG_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = '`bill_reg_address`';
        }
        if ($this->isColumnModified(StorePeer::BILLING_ADDRESS_ID)) {
            $modifiedColumns[':p' . $index++]  = '`billing_address_id`';
        }
        if ($this->isColumnModified(StorePeer::TELEPHONE)) {
            $modifiedColumns[':p' . $index++]  = '`telephone`';
        }
        if ($this->isColumnModified(StorePeer::FAX)) {
            $modifiedColumns[':p' . $index++]  = '`fax`';
        }
        if ($this->isColumnModified(StorePeer::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(StorePeer::DOMAIN)) {
            $modifiedColumns[':p' . $index++]  = '`domain`';
        }
        if ($this->isColumnModified(StorePeer::REALM)) {
            $modifiedColumns[':p' . $index++]  = '`realm`';
        }
        if ($this->isColumnModified(StorePeer::HOST)) {
            $modifiedColumns[':p' . $index++]  = '`host`';
        }
        if ($this->isColumnModified(StorePeer::HOSTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`hostname`';
        }
        if ($this->isColumnModified(StorePeer::WEBSITE)) {
            $modifiedColumns[':p' . $index++]  = '`website`';
        }
        if ($this->isColumnModified(StorePeer::LOGO)) {
            $modifiedColumns[':p' . $index++]  = '`logo`';
        }
        if ($this->isColumnModified(StorePeer::CURRENCY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`currency_id`';
        }
        if ($this->isColumnModified(StorePeer::TAX_INCLUDED)) {
            $modifiedColumns[':p' . $index++]  = '`tax_included`';
        }
        if ($this->isColumnModified(StorePeer::DEFAULT_CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`default_category_id`';
        }
        if ($this->isColumnModified(StorePeer::LOADING)) {
            $modifiedColumns[':p' . $index++]  = '`loading`';
        }
        if ($this->isColumnModified(StorePeer::TEMPLATE_MINIFIED)) {
            $modifiedColumns[':p' . $index++]  = '`template_minified`';
        }
        if ($this->isColumnModified(StorePeer::KEY)) {
            $modifiedColumns[':p' . $index++]  = '`key`';
        }
        if ($this->isColumnModified(StorePeer::TESTCODE)) {
            $modifiedColumns[':p' . $index++]  = '`testcode`';
        }
        if ($this->isColumnModified(StorePeer::ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = '`active`';
        }
        if ($this->isColumnModified(StorePeer::SUSPENDED)) {
            $modifiedColumns[':p' . $index++]  = '`suspended`';
        }
        if ($this->isColumnModified(StorePeer::STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`status`';
        }
        if ($this->isColumnModified(StorePeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(StorePeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }
        if ($this->isColumnModified(StorePeer::DELETED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`deleted_at`';
        }
        if ($this->isColumnModified(StorePeer::PLAN_ID)) {
            $modifiedColumns[':p' . $index++]  = '`plan_id`';
        }
        if ($this->isColumnModified(StorePeer::EXPIRES_AT)) {
            $modifiedColumns[':p' . $index++]  = '`expires_at`';
        }
        if ($this->isColumnModified(StorePeer::AFFILIATE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`affiliate_id`';
        }
        if ($this->isColumnModified(StorePeer::OAUTH_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = '`oauth_token`';
        }
        if ($this->isColumnModified(StorePeer::YEAR_END)) {
            $modifiedColumns[':p' . $index++]  = '`year_end`';
        }
        if ($this->isColumnModified(StorePeer::COUNTRY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`country_id`';
        }

        $sql = sprintf(
            'INSERT INTO `store` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`owner_id`':
                        $stmt->bindValue($identifier, $this->owner_id, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`type_id`':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
                        break;
                    case '`rcs`':
                        $stmt->bindValue($identifier, $this->rcs, PDO::PARAM_STR);
                        break;
                    case '`siren`':
                        $stmt->bindValue($identifier, $this->siren, PDO::PARAM_STR);
                        break;
                    case '`naf`':
                        $stmt->bindValue($identifier, $this->naf, PDO::PARAM_STR);
                        break;
                    case '`vat_id`':
                        $stmt->bindValue($identifier, $this->vat_id, PDO::PARAM_STR);
                        break;
                    case '`address_id`':
                        $stmt->bindValue($identifier, $this->address_id, PDO::PARAM_INT);
                        break;
                    case '`bill_reg_address`':
                        $stmt->bindValue($identifier, $this->bill_reg_address, PDO::PARAM_INT);
                        break;
                    case '`billing_address_id`':
                        $stmt->bindValue($identifier, $this->billing_address_id, PDO::PARAM_INT);
                        break;
                    case '`telephone`':
                        $stmt->bindValue($identifier, $this->telephone, PDO::PARAM_STR);
                        break;
                    case '`fax`':
                        $stmt->bindValue($identifier, $this->fax, PDO::PARAM_STR);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`domain`':
                        $stmt->bindValue($identifier, $this->domain, PDO::PARAM_STR);
                        break;
                    case '`realm`':
                        $stmt->bindValue($identifier, $this->realm, PDO::PARAM_STR);
                        break;
                    case '`host`':
                        $stmt->bindValue($identifier, $this->host, PDO::PARAM_STR);
                        break;
                    case '`hostname`':
                        $stmt->bindValue($identifier, $this->hostname, PDO::PARAM_STR);
                        break;
                    case '`website`':
                        $stmt->bindValue($identifier, $this->website, PDO::PARAM_STR);
                        break;
                    case '`logo`':
                        $stmt->bindValue($identifier, $this->logo, PDO::PARAM_STR);
                        break;
                    case '`currency_id`':
                        $stmt->bindValue($identifier, $this->currency_id, PDO::PARAM_STR);
                        break;
                    case '`tax_included`':
                        $stmt->bindValue($identifier, $this->tax_included, PDO::PARAM_INT);
                        break;
                    case '`default_category_id`':
                        $stmt->bindValue($identifier, $this->default_category_id, PDO::PARAM_INT);
                        break;
                    case '`loading`':
                        $stmt->bindValue($identifier, $this->loading, PDO::PARAM_STR);
                        break;
                    case '`template_minified`':
                        $stmt->bindValue($identifier, $this->template_minified, PDO::PARAM_STR);
                        break;
                    case '`key`':
                        $stmt->bindValue($identifier, $this->key, PDO::PARAM_STR);
                        break;
                    case '`testcode`':
                        $stmt->bindValue($identifier, $this->testcode, PDO::PARAM_STR);
                        break;
                    case '`active`':
                        $stmt->bindValue($identifier, (int) $this->active, PDO::PARAM_INT);
                        break;
                    case '`suspended`':
                        $stmt->bindValue($identifier, (int) $this->suspended, PDO::PARAM_INT);
                        break;
                    case '`status`':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`updated_at`':
                        $stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
                        break;
                    case '`deleted_at`':
                        $stmt->bindValue($identifier, $this->deleted_at, PDO::PARAM_STR);
                        break;
                    case '`plan_id`':
                        $stmt->bindValue($identifier, $this->plan_id, PDO::PARAM_INT);
                        break;
                    case '`expires_at`':
                        $stmt->bindValue($identifier, $this->expires_at, PDO::PARAM_STR);
                        break;
                    case '`affiliate_id`':
                        $stmt->bindValue($identifier, $this->affiliate_id, PDO::PARAM_INT);
                        break;
                    case '`oauth_token`':
                        $stmt->bindValue($identifier, $this->oauth_token, PDO::PARAM_STR);
                        break;
                    case '`year_end`':
                        $stmt->bindValue($identifier, (int) $this->year_end, PDO::PARAM_INT);
                        break;
                    case '`country_id`':
                        $stmt->bindValue($identifier, $this->country_id, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     *               @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param  mixed   $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     *                         @see        doValidate()
     *                         @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param  array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();

            if (($retval = StorePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }

            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param  string $name name
     * @param  string $type The type of fieldname the $name is of:
     *                      one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                      Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed  Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = StorePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int   $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getOwnerId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getTypeId();
                break;
            case 4:
                return $this->getRcs();
                break;
            case 5:
                return $this->getSiren();
                break;
            case 6:
                return $this->getNaf();
                break;
            case 7:
                return $this->getVatId();
                break;
            case 8:
                return $this->getAddressId();
                break;
            case 9:
                return $this->getBillRegAddress();
                break;
            case 10:
                return $this->getBillingAddressId();
                break;
            case 11:
                return $this->getTelephone();
                break;
            case 12:
                return $this->getFax();
                break;
            case 13:
                return $this->getEmail();
                break;
            case 14:
                return $this->getDomain();
                break;
            case 15:
                return $this->getRealm();
                break;
            case 16:
                return $this->getHost();
                break;
            case 17:
                return $this->getHostname();
                break;
            case 18:
                return $this->getWebsite();
                break;
            case 19:
                return $this->getLogo();
                break;
            case 20:
                return $this->getCurrencyId();
                break;
            case 21:
                return $this->getTaxIncluded();
                break;
            case 22:
                return $this->getDefaultCategoryId();
                break;
            case 23:
                return $this->getLoading();
                break;
            case 24:
                return $this->getTemplateMinified();
                break;
            case 25:
                return $this->getKey();
                break;
            case 26:
                return $this->getTestcode();
                break;
            case 27:
                return $this->getActive();
                break;
            case 28:
                return $this->getSuspended();
                break;
            case 29:
                return $this->getStatus();
                break;
            case 30:
                return $this->getCreatedAt();
                break;
            case 31:
                return $this->getUpdatedAt();
                break;
            case 32:
                return $this->getDeletedAt();
                break;
            case 33:
                return $this->getPlanId();
                break;
            case 34:
                return $this->getExpiresAt();
                break;
            case 35:
                return $this->getAffiliateId();
                break;
            case 36:
                return $this->getOauthToken();
                break;
            case 37:
                return $this->getYearEnd();
                break;
            case 38:
                return $this->getCountryId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string  $keyType                (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                                        Defaults to BasePeer::TYPE_PHPNAME.
     * @param boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param array   $alreadyDumpedObjects   List of objects to skip to avoid recursion
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {
        if (isset($alreadyDumpedObjects['Store'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Store'][$this->getPrimaryKey()] = true;
        $keys = StorePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getOwnerId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getTypeId(),
            $keys[4] => $this->getRcs(),
            $keys[5] => $this->getSiren(),
            $keys[6] => $this->getNaf(),
            $keys[7] => $this->getVatId(),
            $keys[8] => $this->getAddressId(),
            $keys[9] => $this->getBillRegAddress(),
            $keys[10] => $this->getBillingAddressId(),
            $keys[11] => $this->getTelephone(),
            $keys[12] => $this->getFax(),
            $keys[13] => $this->getEmail(),
            $keys[14] => $this->getDomain(),
            $keys[15] => $this->getRealm(),
            $keys[16] => $this->getHost(),
            $keys[17] => $this->getHostname(),
            $keys[18] => $this->getWebsite(),
            $keys[19] => $this->getLogo(),
            $keys[20] => $this->getCurrencyId(),
            $keys[21] => $this->getTaxIncluded(),
            $keys[22] => $this->getDefaultCategoryId(),
            $keys[23] => $this->getLoading(),
            $keys[24] => $this->getTemplateMinified(),
            $keys[25] => $this->getKey(),
            $keys[26] => $this->getTestcode(),
            $keys[27] => $this->getActive(),
            $keys[28] => $this->getSuspended(),
            $keys[29] => $this->getStatus(),
            $keys[30] => $this->getCreatedAt(),
            $keys[31] => $this->getUpdatedAt(),
            $keys[32] => $this->getDeletedAt(),
            $keys[33] => $this->getPlanId(),
            $keys[34] => $this->getExpiresAt(),
            $keys[35] => $this->getAffiliateId(),
            $keys[36] => $this->getOauthToken(),
            $keys[37] => $this->getYearEnd(),
            $keys[38] => $this->getCountryId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name  peer name
     * @param  mixed  $value field value
     * @param  string $type  The type of fieldname the $name is of:
     *                       one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                       BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                       Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = StorePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int   $pos   position in xml schema
     * @param  mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setOwnerId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setTypeId($value);
                break;
            case 4:
                $this->setRcs($value);
                break;
            case 5:
                $this->setSiren($value);
                break;
            case 6:
                $this->setNaf($value);
                break;
            case 7:
                $this->setVatId($value);
                break;
            case 8:
                $this->setAddressId($value);
                break;
            case 9:
                $this->setBillRegAddress($value);
                break;
            case 10:
                $this->setBillingAddressId($value);
                break;
            case 11:
                $this->setTelephone($value);
                break;
            case 12:
                $this->setFax($value);
                break;
            case 13:
                $this->setEmail($value);
                break;
            case 14:
                $this->setDomain($value);
                break;
            case 15:
                $this->setRealm($value);
                break;
            case 16:
                $this->setHost($value);
                break;
            case 17:
                $this->setHostname($value);
                break;
            case 18:
                $this->setWebsite($value);
                break;
            case 19:
                $this->setLogo($value);
                break;
            case 20:
                $this->setCurrencyId($value);
                break;
            case 21:
                $this->setTaxIncluded($value);
                break;
            case 22:
                $this->setDefaultCategoryId($value);
                break;
            case 23:
                $this->setLoading($value);
                break;
            case 24:
                $this->setTemplateMinified($value);
                break;
            case 25:
                $this->setKey($value);
                break;
            case 26:
                $this->setTestcode($value);
                break;
            case 27:
                $this->setActive($value);
                break;
            case 28:
                $this->setSuspended($value);
                break;
            case 29:
                $this->setStatus($value);
                break;
            case 30:
                $this->setCreatedAt($value);
                break;
            case 31:
                $this->setUpdatedAt($value);
                break;
            case 32:
                $this->setDeletedAt($value);
                break;
            case 33:
                $this->setPlanId($value);
                break;
            case 34:
                $this->setExpiresAt($value);
                break;
            case 35:
                $this->setAffiliateId($value);
                break;
            case 36:
                $this->setOauthToken($value);
                break;
            case 37:
                $this->setYearEnd($value);
                break;
            case 38:
                $this->setCountryId($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param  array  $arr     An array to populate the object from.
     * @param  string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = StorePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setOwnerId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setTypeId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setRcs($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSiren($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setNaf($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setVatId($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setAddressId($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setBillRegAddress($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setBillingAddressId($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setTelephone($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setFax($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setEmail($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setDomain($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setRealm($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setHost($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setHostname($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setWebsite($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setLogo($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setCurrencyId($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setTaxIncluded($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setDefaultCategoryId($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setLoading($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setTemplateMinified($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setKey($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setTestcode($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setActive($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setSuspended($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setStatus($arr[$keys[29]]);
        if (array_key_exists($keys[30], $arr)) $this->setCreatedAt($arr[$keys[30]]);
        if (array_key_exists($keys[31], $arr)) $this->setUpdatedAt($arr[$keys[31]]);
        if (array_key_exists($keys[32], $arr)) $this->setDeletedAt($arr[$keys[32]]);
        if (array_key_exists($keys[33], $arr)) $this->setPlanId($arr[$keys[33]]);
        if (array_key_exists($keys[34], $arr)) $this->setExpiresAt($arr[$keys[34]]);
        if (array_key_exists($keys[35], $arr)) $this->setAffiliateId($arr[$keys[35]]);
        if (array_key_exists($keys[36], $arr)) $this->setOauthToken($arr[$keys[36]]);
        if (array_key_exists($keys[37], $arr)) $this->setYearEnd($arr[$keys[37]]);
        if (array_key_exists($keys[38], $arr)) $this->setCountryId($arr[$keys[38]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(StorePeer::DATABASE_NAME);

        if ($this->isColumnModified(StorePeer::ID)) $criteria->add(StorePeer::ID, $this->id);
        if ($this->isColumnModified(StorePeer::OWNER_ID)) $criteria->add(StorePeer::OWNER_ID, $this->owner_id);
        if ($this->isColumnModified(StorePeer::NAME)) $criteria->add(StorePeer::NAME, $this->name);
        if ($this->isColumnModified(StorePeer::TYPE_ID)) $criteria->add(StorePeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(StorePeer::RCS)) $criteria->add(StorePeer::RCS, $this->rcs);
        if ($this->isColumnModified(StorePeer::SIREN)) $criteria->add(StorePeer::SIREN, $this->siren);
        if ($this->isColumnModified(StorePeer::NAF)) $criteria->add(StorePeer::NAF, $this->naf);
        if ($this->isColumnModified(StorePeer::VAT_ID)) $criteria->add(StorePeer::VAT_ID, $this->vat_id);
        if ($this->isColumnModified(StorePeer::ADDRESS_ID)) $criteria->add(StorePeer::ADDRESS_ID, $this->address_id);
        if ($this->isColumnModified(StorePeer::BILL_REG_ADDRESS)) $criteria->add(StorePeer::BILL_REG_ADDRESS, $this->bill_reg_address);
        if ($this->isColumnModified(StorePeer::BILLING_ADDRESS_ID)) $criteria->add(StorePeer::BILLING_ADDRESS_ID, $this->billing_address_id);
        if ($this->isColumnModified(StorePeer::TELEPHONE)) $criteria->add(StorePeer::TELEPHONE, $this->telephone);
        if ($this->isColumnModified(StorePeer::FAX)) $criteria->add(StorePeer::FAX, $this->fax);
        if ($this->isColumnModified(StorePeer::EMAIL)) $criteria->add(StorePeer::EMAIL, $this->email);
        if ($this->isColumnModified(StorePeer::DOMAIN)) $criteria->add(StorePeer::DOMAIN, $this->domain);
        if ($this->isColumnModified(StorePeer::REALM)) $criteria->add(StorePeer::REALM, $this->realm);
        if ($this->isColumnModified(StorePeer::HOST)) $criteria->add(StorePeer::HOST, $this->host);
        if ($this->isColumnModified(StorePeer::HOSTNAME)) $criteria->add(StorePeer::HOSTNAME, $this->hostname);
        if ($this->isColumnModified(StorePeer::WEBSITE)) $criteria->add(StorePeer::WEBSITE, $this->website);
        if ($this->isColumnModified(StorePeer::LOGO)) $criteria->add(StorePeer::LOGO, $this->logo);
        if ($this->isColumnModified(StorePeer::CURRENCY_ID)) $criteria->add(StorePeer::CURRENCY_ID, $this->currency_id);
        if ($this->isColumnModified(StorePeer::TAX_INCLUDED)) $criteria->add(StorePeer::TAX_INCLUDED, $this->tax_included);
        if ($this->isColumnModified(StorePeer::DEFAULT_CATEGORY_ID)) $criteria->add(StorePeer::DEFAULT_CATEGORY_ID, $this->default_category_id);
        if ($this->isColumnModified(StorePeer::LOADING)) $criteria->add(StorePeer::LOADING, $this->loading);
        if ($this->isColumnModified(StorePeer::TEMPLATE_MINIFIED)) $criteria->add(StorePeer::TEMPLATE_MINIFIED, $this->template_minified);
        if ($this->isColumnModified(StorePeer::KEY)) $criteria->add(StorePeer::KEY, $this->key);
        if ($this->isColumnModified(StorePeer::TESTCODE)) $criteria->add(StorePeer::TESTCODE, $this->testcode);
        if ($this->isColumnModified(StorePeer::ACTIVE)) $criteria->add(StorePeer::ACTIVE, $this->active);
        if ($this->isColumnModified(StorePeer::SUSPENDED)) $criteria->add(StorePeer::SUSPENDED, $this->suspended);
        if ($this->isColumnModified(StorePeer::STATUS)) $criteria->add(StorePeer::STATUS, $this->status);
        if ($this->isColumnModified(StorePeer::CREATED_AT)) $criteria->add(StorePeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(StorePeer::UPDATED_AT)) $criteria->add(StorePeer::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(StorePeer::DELETED_AT)) $criteria->add(StorePeer::DELETED_AT, $this->deleted_at);
        if ($this->isColumnModified(StorePeer::PLAN_ID)) $criteria->add(StorePeer::PLAN_ID, $this->plan_id);
        if ($this->isColumnModified(StorePeer::EXPIRES_AT)) $criteria->add(StorePeer::EXPIRES_AT, $this->expires_at);
        if ($this->isColumnModified(StorePeer::AFFILIATE_ID)) $criteria->add(StorePeer::AFFILIATE_ID, $this->affiliate_id);
        if ($this->isColumnModified(StorePeer::OAUTH_TOKEN)) $criteria->add(StorePeer::OAUTH_TOKEN, $this->oauth_token);
        if ($this->isColumnModified(StorePeer::YEAR_END)) $criteria->add(StorePeer::YEAR_END, $this->year_end);
        if ($this->isColumnModified(StorePeer::COUNTRY_ID)) $criteria->add(StorePeer::COUNTRY_ID, $this->country_id);
        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(StorePeer::DATABASE_NAME);
        $criteria->add(StorePeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int  $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  object          $copyObj  An object of Store (or compatible) type.
     * @param  boolean         $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param  boolean         $makeNew  Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setOwnerId($this->getOwnerId());
        $copyObj->setName($this->getName());
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setRcs($this->getRcs());
        $copyObj->setSiren($this->getSiren());
        $copyObj->setNaf($this->getNaf());
        $copyObj->setVatId($this->getVatId());
        $copyObj->setAddressId($this->getAddressId());
        $copyObj->setBillRegAddress($this->getBillRegAddress());
        $copyObj->setBillingAddressId($this->getBillingAddressId());
        $copyObj->setTelephone($this->getTelephone());
        $copyObj->setFax($this->getFax());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setDomain($this->getDomain());
        $copyObj->setRealm($this->getRealm());
        $copyObj->setHost($this->getHost());
        $copyObj->setHostname($this->getHostname());
        $copyObj->setWebsite($this->getWebsite());
        $copyObj->setLogo($this->getLogo());
        $copyObj->setCurrencyId($this->getCurrencyId());
        $copyObj->setTaxIncluded($this->getTaxIncluded());
        $copyObj->setDefaultCategoryId($this->getDefaultCategoryId());
        $copyObj->setLoading($this->getLoading());
        $copyObj->setTemplateMinified($this->getTemplateMinified());
        $copyObj->setKey($this->getKey());
        $copyObj->setTestcode($this->getTestcode());
        $copyObj->setActive($this->getActive());
        $copyObj->setSuspended($this->getSuspended());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setDeletedAt($this->getDeletedAt());
        $copyObj->setPlanId($this->getPlanId());
        $copyObj->setExpiresAt($this->getExpiresAt());
        $copyObj->setAffiliateId($this->getAffiliateId());
        $copyObj->setOauthToken($this->getOauthToken());
        $copyObj->setYearEnd($this->getYearEnd());
        $copyObj->setCountryId($this->getCountryId());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean         $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Store           Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return StorePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new StorePeer();
        }

        return self::$peer;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->owner_id = null;
        $this->name = null;
        $this->type_id = null;
        $this->rcs = null;
        $this->siren = null;
        $this->naf = null;
        $this->vat_id = null;
        $this->address_id = null;
        $this->bill_reg_address = null;
        $this->billing_address_id = null;
        $this->telephone = null;
        $this->fax = null;
        $this->email = null;
        $this->domain = null;
        $this->realm = null;
        $this->host = null;
        $this->hostname = null;
        $this->website = null;
        $this->logo = null;
        $this->currency_id = null;
        $this->tax_included = null;
        $this->default_category_id = null;
        $this->loading = null;
        $this->template_minified = null;
        $this->key = null;
        $this->testcode = null;
        $this->active = null;
        $this->suspended = null;
        $this->status = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->deleted_at = null;
        $this->plan_id = null;
        $this->expires_at = null;
        $this->affiliate_id = null;
        $this->oauth_token = null;
        $this->year_end = null;
        $this->country_id = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StorePeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
