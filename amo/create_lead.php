<?php

use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Collections\CompaniesCollection;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Collections\NullTagsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\CompanyModel;
use AmoCRM\Models\ContactModel;
use AmoCRM\Collections\NotesCollection;
use AmoCRM\Models\NoteType\CommonNote;
use AmoCRM\Models\NoteType\ServiceMessageNote;
use AmoCRM\Filters\ContactsFilter;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NullCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Models\CustomFieldsValues\SelectCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\SelectCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\SelectCustomFieldValueModel;

class amoCRM
{
    public function add_lead($lead_data) {
        include_once __DIR__ . '/bootstrap.php';

        $name = $lead_data['NAME'];
        $phone = $lead_data['PHONE'];
        $leadName = $lead_data['LEAD_NAME'];

        $accessToken = getToken();

        $apiClient->setAccessToken($accessToken)
            ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken, string $baseDomain) {
                    saveToken([
                        'accessToken' => $accessToken->getToken(),
                        'refreshToken' => $accessToken->getRefreshToken(),
                        'expires' => $accessToken->getExpires(),
                        'baseDomain' => $baseDomain,
                    ]);
                }
            );

        $leadsService = $apiClient->leads();

        try {
            $contacts = $apiClient->contacts()->get((new ContactsFilter())->setQuery($phone));
            $contact = $contacts[0];
        } catch(AmoCRMApiException $e) {
            $contact = new ContactModel();
            $contact->setName($name)->setIsMain(true);

            $CustomFieldsValues = new CustomFieldsValuesCollection();

            $phoneField = (new MultitextCustomFieldValuesModel())->setFieldCode('PHONE');
            $phoneField->setValues((new MultitextCustomFieldValueCollection())->add((new MultitextCustomFieldValueModel())->setEnum('WORK')->setValue($phone)));

            $CustomFieldsValues->add($phoneField);

            $contact->setCustomFieldsValues($CustomFieldsValues);

            try {
                $contactModel = $apiClient->contacts()->addOne($contact);
            } catch (AmoCRMApiException $e) {

            }
        }

        // Создаем сделку
        $lead = new LeadModel();
        $lead->setName($leadName)->setPipelineId(4899844)->setContacts((new ContactsCollection())->add(($contact)));

        $CustomFieldsValues = new CustomFieldsValuesCollection();

        $utmContentField = (new TextCustomFieldValuesModel())->setFieldId(325505);
        $utmContentField2 = (new TextCustomFieldValuesModel())->setFieldId(247523);
        $utmContentField->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_content'])));
        $utmContentField2->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_content'])));

        $utmSourceField = (new TextCustomFieldValuesModel())->setFieldId(325497);
        $utmSourceField2 = (new TextCustomFieldValuesModel())->setFieldId(247523);
        $utmSourceField->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_source'])));
        $utmSourceField2->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_source'])));

        $utmMediumField = (new TextCustomFieldValuesModel())->setFieldId(325499);
        $utmMediumField2 = (new TextCustomFieldValuesModel())->setFieldId(247517);
        $utmMediumField->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_medium'])));
        $utmMediumField2->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_medium'])));

        $utmCampaignField = (new TextCustomFieldValuesModel())->setFieldId(325501);
        $utmCampaignField2 = (new TextCustomFieldValuesModel())->setFieldId(247511);
        $utmCampaignField->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_campaign'])));
        $utmCampaignField2->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_campaign'])));

        $utmTermField = (new TextCustomFieldValuesModel())->setFieldId(325503);
        $utmTermField2 = (new TextCustomFieldValuesModel())->setFieldId(247519);
        $utmTermField->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_term'])));
        $utmTermField2->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_COOKIE['utm_term'])));

        $CustomFieldsValues->add($utmContentField);
        $CustomFieldsValues->add($utmSourceField);
        $CustomFieldsValues->add($utmMediumField);
        $CustomFieldsValues->add($utmCampaignField);
        $CustomFieldsValues->add($utmTermField);

        $lead->setCustomFieldsValues($CustomFieldsValues);
        $leadsCollection = new LeadsCollection();
        $leadsCollection->add($lead);

        try {
            $leadsCollection = $leadsService->add($leadsCollection);
        } catch (AmoCRMApiException $e) {

        }
    }
}