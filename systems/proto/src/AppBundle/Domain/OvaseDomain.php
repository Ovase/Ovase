<?php

namespace AppBundle\Domain;

class OvaseDomain {

    public static function getMeasureTypeChoices() {
        // Most recent version of list
        $measureTypes = array(
            'Regnbed',
            'Takfordrøyning (grønne/blå-grå/kombinasjon)',
            'Grønne vegger',
            'Permeable flater',
            'Gatetrær',
            'Grøft',
            'Kum',
            'Vadi (åpen og periodevis tørr vannvei)',
            'Åpen bekkeløsning',
            'Kulvert',
            'Lukket fordrøyningsbasseng',
            'Åpent fordrøyningsbasseng (periodevis tørt)',
            'Dam (permanent vannspeil)',
            'Våtmark',
            'Gate/vei utformet som flomvei',
            'Gjenbruk av regnvann',
            'Annet',
            );
        return array_combine($measureTypes, $measureTypes);
    }

    public static function getMeasureFunctionChoices() {
        // Nested arrays result in optgroups in the select input
        $measureFunctions = array(
            'Hydrologisk' => array(
                'Infiltrasjon',
                'Filtrering',
                'Evapotranspirasjon',
                'Åpen transport',
                'Lukket transport',
                'Lagring for forsinkelse',
                'Lagring for gjenbruk',
                'Avfallshåndtering',
                'Sedimenthåndtering',
                'Rensing',
                ),
            'Økologisk' => array(
                'Biodiversitet',
                'Tilrettelegging for fisk',
                ),
            'Opplevelsesmessig' => array(
                'Lek og læring',
                'Rekreasjon',
                'Oppholdsplass',
                'Bading',
                'Sosial arena',
                'Støydemping',
                'Virke svalende',
                'Urbant landbruk',
                'Birøkting',
                'Fisking',
                'Skille mellom bruksområder'
                ),
            );
        foreach ($measureFunctions as $key => &$val) {
            $val = array_combine($val, $val);
        }
        return $measureFunctions;
    }

    public static function getCompanyTypeChoices() {
        $types = array(
            'Arkitekt',
            'Landskapsarkitekt',
            'Konsulent',
            'Anleggsgartner',
            'Entreprenør',
            'Leverandør',
            'Kommune',
            'Interkommunalt Selskap',
            'Offentlig utbygger og eier',
            'Privat utbygger',
            'Privat eier',
            'Forskning',
            'Utvikling og Innovasjon',
            'Utdanning',
            'Interesseorganisasjon',
            'Non-profit organisasjon',
            'Annet',
            );
        return array_combine($types, $types);
    }

    public static function getPersonTypeChoices() {
        $types = array(
            'Arkitekt',
            'Landskapsarkitekt',
            'Konsulent',
            'Anleggsgartner',
            'Entreprenør',
            'Leverandør',
            'Kommune',
            'Interkommunalt selskap',
            'Offentlig utbygger og eier',
            'Privat utbygger',
            'Privat eier',
            'Forskning',
            'Utvikling og Innovasjon',
            'Utdanning',
            'Interesseorganisasjon',
            'Non-profit organisasjon',
            'Studerende',
            'Kommune in-house',
            'Kommune drift',
            'Engasjert innbygger',
            'Huseier',
            'Annet',
            );
        return array_combine($types, $types);
    }

    public static function getProjectTypeChoices() {
        $types = array(
            'Nybygg',
            'Ombygg',
            'Kombinasjon av nybygg og ombygg',
            );
        return array_combine($types, $types);
    }

    public static function getMaintenanceDealChoices() {
        $choices = array(
            'Ja',
            'Nei',
            'Uavklart',
            );
        return array_combine($choices, $choices);
    }

    public static function getMeasureInstrumentationChoices() {
        $choices = array(
            'Ja',
            'Nei',
            'Uvisst',
            );
        return array_combine($choices, $choices);
    }
}
