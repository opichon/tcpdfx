<?php

namespace Dzangocart\Bundle\CoreBundle\Model\map;

use \RelationMap;
use \TableMap;

/**
 * This class defines the structure of the 'store' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Dzangocart.Bundle.CoreBundle.Model.map
 */
class StoreTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Dzangocart.Bundle.CoreBundle.Model.map.StoreTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('store');
        $this->setPhpName('Store');
        $this->setClassname('Dzangocart\\Bundle\\CoreBundle\\Model\\Store');
        $this->setPackage('src.Dzangocart.Bundle.CoreBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('owner_id', 'OwnerId', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 100, null);
        $this->addColumn('type_id', 'TypeId', 'INTEGER', false, null, null);
        $this->addColumn('rcs', 'Rcs', 'VARCHAR', false, 128, null);
        $this->addColumn('siren', 'Siren', 'VARCHAR', false, 9, null);
        $this->addColumn('naf', 'Naf', 'VARCHAR', false, 5, null);
        $this->addColumn('vat_id', 'VatId', 'VARCHAR', false, 14, null);
        $this->addColumn('address_id', 'AddressId', 'INTEGER', false, null, null);
        $this->addColumn('bill_reg_address', 'BillRegAddress', 'TINYINT', false, null, 1);
        $this->addColumn('billing_address_id', 'BillingAddressId', 'INTEGER', false, null, null);
        $this->addColumn('telephone', 'Telephone', 'VARCHAR', false, 20, null);
        $this->addColumn('fax', 'Fax', 'VARCHAR', false, 20, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 100, null);
        $this->addColumn('domain', 'Domain', 'VARCHAR', true, 32, null);
        $this->addColumn('realm', 'Realm', 'VARCHAR', true, 32, null);
        $this->addColumn('host', 'Host', 'VARCHAR', false, 128, null);
        $this->addColumn('hostname', 'Hostname', 'VARCHAR', false, 132, null);
        $this->addColumn('website', 'Website', 'VARCHAR', false, 128, null);
        $this->addColumn('logo', 'Logo', 'VARCHAR', false, 256, null);
        $this->addColumn('currency_id', 'CurrencyId', 'VARCHAR', true, 3, 'EUR');
        $this->addColumn('tax_included', 'TaxIncluded', 'TINYINT', true, null, 0);
        $this->addColumn('default_category_id', 'DefaultCategoryId', 'INTEGER', false, null, null);
        $this->addColumn('loading', 'Loading', 'VARCHAR', false, 50, null);
        $this->addColumn('template_minified', 'TemplateMinified', 'LONGVARCHAR', false, null, null);
        $this->addColumn('key', 'Key', 'VARCHAR', false, 40, null);
        $this->addColumn('testcode', 'Testcode', 'VARCHAR', false, 32, null);
        $this->addColumn('active', 'Active', 'BOOLEAN', true, 1, false);
        $this->addColumn('suspended', 'Suspended', 'BOOLEAN', true, 1, false);
        $this->addColumn('status', 'Status', 'INTEGER', true, null, 0);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('deleted_at', 'DeletedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('plan_id', 'PlanId', 'INTEGER', false, null, null);
        $this->addColumn('expires_at', 'ExpiresAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('affiliate_id', 'AffiliateId', 'INTEGER', false, null, null);
        $this->addColumn('oauth_token', 'OauthToken', 'VARCHAR', false, 64, null);
        $this->addColumn('year_end', 'YearEnd', 'BOOLEAN', true, 1, true);
        $this->addColumn('country_id', 'CountryId', 'VARCHAR', true, 2, 'FR');
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // StoreTableMap
