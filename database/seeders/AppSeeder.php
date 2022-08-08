<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{FederalEntity, Settlement, SettlementType, ZipCode, Municipality};
use Illuminate\Support\Facades\DB;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = glob(database_path("seeders/csv/*.csv"));
        foreach($files as $file)
        {
            $csv_file = file_get_contents($file);
            $data = collect(explode("\n",$csv_file));
            $headers = explode(";",$data[0]);
            $data = $data->map(function($item, $index) use($headers){
                if(!$index || $item == "") return null;
                $d = explode(";", $item);
                return array_combine($headers, $d);
            })->filter(fn($item) => is_array($item));

            $federal = $municipalities = $settlements = $zips = [];
            foreach($data as $k => $row)
            {
                $fed = $this->fedData($row);
                $mun = $this->municipalityData($row);
                $set = $this->settlementData($row);
                $set['federal_entity_id']=$fed['key'];
                $set['type_id'] = SettlementType::firstOrCreate(['id' => $row['st_id']],['name' => $row['st_name']])->id;
                $zip = [
                    'zip_code' => $row['z_zip_code'],
                    'locality' => $row['z_locality'],
                    'municipality_id' => $mun['key'],
                    'federal_entity_id' => $fed['key'],
                ];

                //Once a new entity is stored is assigned in an array to avoid repetetitive queries
                if(!isset($federal[$fed['key']]))
                    $federal[$fed['key']]= FederalEntity::firstOrCreate(['key' => $fed['key']],$fed);

                if(!isset($settlements[$set['key']]))
                    $settlements[$set['key']]= Settlement::firstOrCreate(['key' => $set['key'], 'federal_entity_id' => $fed['key']],$set);

                if(!isset($municipalities[$mun['key']]))
                    $municipalities[$mun['key']]= Municipality::firstOrCreate(['key' => $mun['key']],$mun);

                if(!isset($zips[$zip['zip_code']]))
                    $zips[$zip['zip_code']] = ZipCode::firstOrCreate(['zip_code' => $zip['zip_code']],$zip);

                $insert = ['zip_code' => $zip['zip_code'], 'settlement' => $settlements[$set['key']]->id];
                DB::table('zip_codes_has_settlements')->upsert($insert,$insert);
            }
        }
        $this->command->info('Base de datos migrada llenada');
    }

    private function fedData(array $row):array
    {
        $tmp =collect($row)->filter(fn ($val, $key) => substr($key,0,3) == 'fed');
        $tmp = $this->remove_array_prefix($tmp->toArray(), 'fed_');
        $tmp['key']=intval($tmp['key']);
        $tmp['code']=$tmp['code']?:null;
        return $tmp;
    }

    private function municipalityData(array $row)
    {
        $tmp =collect($row)->filter(fn ($val, $key) => substr($key,0,12) == 'municipality');
        $tmp = $this->remove_array_prefix($tmp->toArray(), 'municipality_');
        $tmp['key']=intval($tmp['key']);
        return $tmp;
    }

    private function settlementData(array $row):array
    {
        $tmp =collect($row)->filter(fn ($val, $key) => substr($key,0,2) == 's_');
        $tmp = $this->remove_array_prefix($tmp->toArray(), 's_');
        $tmp['key']=intval($tmp['key']);
        return $tmp;
    }

    private function remove_array_prefix(array $data, string $substract_prefix)
    {
        $values = array_values($data);
        $keys = collect(array_keys($data))->map(fn($val) => str_replace($substract_prefix,'',$val))->toArray();
        return array_combine($keys,$values);
    }
}
