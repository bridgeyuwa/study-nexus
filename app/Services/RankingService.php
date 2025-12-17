<?php

namespace App\Services;

use App\Models\Institution;

class RankingService
{
    public function computeRank(Institution $institution, $allInstitutions)
    {
        $rank = ['institution' => 0, 'region' => 0, 'state' => 0];

        if ($institution->rank) {
            foreach ($allInstitutions as $school) {
                $rank['institution']++;
                if ($school->id == $institution->id) {
                    break;
                }
            }

            $regionInstitutions = $institution->state->region->institutions
                ->whereNotNull('rank')
                ->where('category_id', $institution->category->id)
                ->sortBy('rank');

            foreach ($regionInstitutions as $regionInstitution) {
                $rank['region']++;
                if ($regionInstitution->id == $institution->id) {
                    break;
                }
            }

            $stateInstitutions = $institution->state->institutions
                ->whereNotNull('rank')
                ->where('category_id', $institution->category->id)
                ->sortBy('rank');

            foreach ($stateInstitutions as $stateInstitution) {
                $rank['state']++;
                if ($stateInstitution->id == $institution->id) {
                    break;
                }
            }
        } else {
            $rank = ['institution' => false, 'region' => false, 'state' => false];
        }

        return $rank;
    }

    public function computeRankings($institutions)
    {
        $rank = [];
        foreach ($institutions as $institution) {
            $rank[$institution->id] = $this->computeRank($institution, $institutions);
        }

        return $rank;
    }
}
