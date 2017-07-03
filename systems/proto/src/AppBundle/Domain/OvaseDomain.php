<?php

namespace AppBundle\Domain;

class OvaseDomain {

    public static function getMeasureTypeChoices() {
        // Tone's list. Currently not used.
        $measureTypes = array(
            'Regnbed',
            'Infiltrasjonsgrøft',
            'Swale/vadi',
            'Takfordrøyning (grønne /grå-blå/kombinasjon)',
            'Lukket fordrøyningsbasseng',
            'Åpen bekkeløsning',
            'Fordrøyningsbasseng (åpent vått eller tørt)',
            'Våtmark',
            'Annen infiltrasjonsbasert løsning',
            'Annen fordrøyningsbasert løsning',
            'Sisterne for gjenbruk av regnvann',
            );
        // Anine's list.
        $measureTypes2 = array(
            'Regnbed',
            'Takfordrøyning (grønne /blå-grå /kombinasjon)',
            'Grønne vegger',
            'Permeabelt dekke',
            'Gatetrær',
            'Grøft',
            'Renne',
            'Kum',
            'Vadi (Åpen vannvei som går tørr i perioder)',
            'Åpen bekkeløsning',
            'Kulvert',
            'Lukket fordrøyningsbasseng',
            'Åpent fordrøyningsbasseng (Naturlig eller urbant senket område som periodevis er tørt)',
            'Dam (Permanent vannspeil)',
            'Våtmark',
            'Gate/vei-flomvei (Gate eller vei bygget/ombygget for å fungere som flomvei i ekstremsituasjoner)',
            'Annet',
            );
        return array_combine($measureTypes2, $measureTypes2);
    }

    public static function getMeasureFunctionChoices() {
        // Nested arrays result in optgroups in the select input
        $measureFunctions = array(
            'Vann-teknisk' => array(
                'Infiltrasjon',
                'Filtrering',
                'Evapotranspirasjon',
                'Åpen transport',
                'Lukket transport',
                'Lagring for forsinkelse',
                'Lagring for gjenbruk',
                'Avfallshåndtering',
                'Rensing',
                ),
            'Økologisk' => array(
                'Biodiversitet',
                'Testverdi2',
                ),
            );
        foreach ($measureFunctions as $key => &$val) {
            $val = array_combine($val, $val);
        }
        return $measureFunctions;
    }
}
