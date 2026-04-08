<?php

namespace App\Actions\Institution;

use Illuminate\Support\Collection;

final class ComputeRankingsAction
{
    public function execute(Collection $institutions): array
    {
        $rank = [];

        foreach ($institutions as $institution) {
            $computedRank = $this->computeRank($institution, $institutions);
            $rank[$institution->id] = [
                'institution' => $computedRank['institution'],
                'region' => $computedRank['region'],
                'state' => $computedRank['state'],
            ];
        }

        return $rank;
    }

    private function computeRank(mixed $institution, mixed $allInstitutions): array
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
}
