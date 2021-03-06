<?php
/**
 * File containing the FieldDefinitionSettingsTemplates class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\Parser;

class FieldDefinitionSettingsTemplates extends Templates
{
    const NODE_KEY = "fielddefinition_settings_templates";
    const INFO = "Template settings for field definition settings rendered by the ez_render_fielddefinition_settings() Twig function";
    const INFO_TEMPLATE_KEY = "Template file where to find block definition to display field definition settings";
}
