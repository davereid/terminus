<?php

namespace Terminus\Models\Collections;

use Terminus\Models\Collections\TerminusCollection;

class OrganizationUserMemberships extends TerminusCollection {
  protected $organization;

  /**
   * Adds a user to this organization
   *
   * @param [User] $user User object of user to add to this organization
   * @return [Workflow] $workflow
   */
  public function addMember($user) {
    $workflow = $this->organization->workflows->create(
      'add_organization_user_membership',
      array(
        'params'    => array(
          'user_id' => $user->get('id'),
          'role'    => 'team_member'
        )
      )
    );
    return $workflow;
  }

  /**
   * Give the URL for collection data fetching
   *
   * @return [string] $url URL to use in fetch query
   */
  protected function getFetchUrl() {
    $url = sprintf(
      'organizations/%s/memberships/users',
      $this->organization->id
    );
    return $url;
  }

  /**
   * Fetches model data from API and instantiates its model instances
   *
   * @param [array] $options params to pass to url request
   * @return [OrganizationUserMemberships] $this
   */
  public function fetch($options = array()) {
    if (!isset($options['paged'])) {
      $options['paged'] = true;
    }

    parent::fetch($options);
    return $this;
  }

  /**
   * Names the model-owner of this collection, false if DNE
   *
   * @return [string] $owner_name
   */
  protected function getOwnerName() {
    $owner_name = 'organization';
    return $owner_name;
  }

}
