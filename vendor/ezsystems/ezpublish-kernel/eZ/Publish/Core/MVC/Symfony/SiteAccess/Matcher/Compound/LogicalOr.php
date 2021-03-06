<?php
/**
 * File containing the LogicalAnd compound siteaccess matcher class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace eZ\Publish\Core\MVC\Symfony\SiteAccess\Matcher\Compound;

use eZ\Publish\Core\MVC\Symfony\SiteAccess\Matcher\Compound;
use eZ\Publish\Core\MVC\Symfony\SiteAccess\VersatileMatcher;

/**
 * Siteaccess matcher that allows a combination of matchers, with a logical OR
 */
class LogicalOr extends Compound
{
    const NAME = 'logicalOr';

    public function match()
    {
        foreach ( $this->config as $i => $rule )
        {
            foreach ( $rule['matchers'] as $subMatcherClass => $matchingConfig )
            {
                if ( $this->matchersMap[$i][$subMatcherClass]->match() )
                {
                    $this->subMatchers = $this->matchersMap[$i];
                    return $rule['match'];
                }
            }
        }

        return false;
    }

    public function reverseMatch( $siteAccessName )
    {
        foreach ( $this->config as $i => $rule )
        {
            if ( $rule['match'] === $siteAccessName )
            {
                foreach ( $this->matchersMap[$i] as $subMatcher )
                {
                    if ( !$subMatcher instanceof VersatileMatcher )
                    {
                        continue;
                    }

                    $reverseMatcher = $subMatcher->reverseMatch( $siteAccessName );
                    if ( !$reverseMatcher )
                    {
                        continue;
                    }

                    $this->setSubMatchers( array( $subMatcher ) );
                    return $this;
                }
            }
        }
    }
}
