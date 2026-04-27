<?php

namespace App\Contracts;

interface GLSTrackingParcelsInterface
{
    public function trackParcelIds(array $parcelData);
    public function trackParcelReferences(array $parcelData);
}