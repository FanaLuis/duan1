<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\TrafficDirectorService;

class DynamicRouteConfig extends \Google\Model
{
  public $lastUpdated;
  public $routeConfig;
  public $versionInfo;

  public function setLastUpdated($lastUpdated)
  {
    $this->lastUpdated = $lastUpdated;
  }
  public function getLastUpdated()
  {
    return $this->lastUpdated;
  }
  public function setRouteConfig($routeConfig)
  {
    $this->routeConfig = $routeConfig;
  }
  public function getRouteConfig()
  {
    return $this->routeConfig;
  }
  public function setVersionInfo($versionInfo)
  {
    $this->versionInfo = $versionInfo;
  }
  public function getVersionInfo()
  {
    return $this->versionInfo;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(DynamicRouteConfig::class, 'Google_Service_TrafficDirectorService_DynamicRouteConfig');
