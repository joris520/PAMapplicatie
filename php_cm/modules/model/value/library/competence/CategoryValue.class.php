<?php

/**
 * Description of CategoryValue
 *
 * @author ben.dokter
 */
class CategoryValue {

    // knowledge_skill.ID_KS
    const JOB_SPECIFIC_ID =  3;
    const PERSONAL_ID     = 32;
    const MANAGERIAL_ID   = 40;

    // knowledge_skill.knowledge_skill
    // De tekst van de knowledge skill staat standaard in Engels in de database
    const JOB_SPECIFIC = 'Job Specific';
    const PERSONAL     = 'Personal';
    const MANAGERIAL   = 'Managerial';

    static function values()
    {
        return array(
            CategoryValue::JOB_SPECIFIC,
            CategoryValue::PERSONAL,
            CategoryValue::MANAGERIAL
            );
    }

}
?>
