<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GlobalController extends Controller
{
    public function index($model, $request, $fields, $with, $withCount, $relations, $where = [], $has = [], $doesntHave = [])
    {
        $search = $request->search;

        $data = $model->select($fields)
            ->where(function ($query) use ($search, $fields, $relations) {
                if ($search) {
                    foreach ($fields as $index => $item) {
                        if ($index === 0) {
                            $query->where($item, 'LIKE', "%" . $search . "%");
                        } else {
                            $query->orWhere($item, 'LIKE', "%" . $search . "%");
                        }
                    }

                    foreach ($relations as $index => $item) {
                        $query->orWhereHas($item[0], function ($query) use ($search, $item) {
                            foreach ($item[1] as $index1 => $item1)
                                if ($index1 === 0) {
                                    $query->where($item1, 'LIKE', "%" . $search . "%");
                                } else {
                                    $query->orWhere($item1, 'LIKE', "%" . $search . "%");
                                }
                        });
                    }
                }
            })
            ->where(function ($query) use ($where) {
                foreach ($where as $item) {
                    $query->where($item[0], $item[1], $item[2]);
                }
            })
            ->where(function ($query) use ($has) {
                if (count($has) > 0) {
                    foreach ($has as $item) {
                        $query->whereHas($item);
                    }
                }
            })
            ->where(function ($query) use ($doesntHave) {
                if (count($doesntHave) > 0) {
                    foreach ($doesntHave as $item) {
                        $query->doesntHave($item);
                    }
                }
            })
            ->when($request, function ($query, $request) {
                $sortBy = $request->sortBy ? $request->sortBy : [];
                $sortDesc = $request->sortDesc ? $request->sortDesc : [];

                if (count($sortBy) > 0) {
                    for ($i = 0; $i < count($sortBy); $i++) {
                        return $query->orderBy($sortBy[$i], $sortDesc[$i] ? 'desc' : 'asc');
                    }
                }
            })
            ->with($with)
            ->withCount($withCount)
            ->paginate($request->itemsPerPage);


        return $data;
    }

    public function store($model, $parameter, $data)
    {
        $result = $model->updateOrCreate($parameter, $data);

        return $result;
    }

    public function get($model, $fields, $where = null, $with = [])
    {
        return $model->select($fields)
            ->where(function ($query) use ($where) {
                if ($where !== null) {
                    $query->where($where);
                }
            })
            ->with($with)
            ->get();
    }

    public function destroy($model, $parameter, $withCount)
    {
        $status = false;

        $data = $model::where($parameter)
            ->withCount($withCount)
            ->first();

        $count = 0;

        foreach ($withCount as $index => $item) {
            $converted = Str::snake($item) . '_count';

            if ($data->$converted === '0' || $data->$converted === 0) {
                $count++;
            }
        }

        var_dump($count);

        if (count($withCount) === $count) {
            $data->delete();
            $status = true;
        }

        return $status;
    }

    public static function convert($number)
    {
        $number = str_replace('.', '', $number);
        if (!is_numeric($number)) throw new Exception("Please input number.");
        $base    = array('nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan');
        $numeric = array('1000000000000000', '1000000000000', '1000000000000', 1000000000, 1000000, 1000, 100, 10, 1);
        $unit    = array('kuadriliun', 'triliun', 'biliun', 'milyar', 'juta', 'ribu', 'ratus', 'puluh', '');
        $str     = null;
        $i = 0;
        if ($number == 0) {
            $str = 'nol';
        } else {
            while ($number != 0) {
                $count = (int)($number / $numeric[$i]);
                if ($count >= 10) {
                    $str .= static::convert($count) . ' ' . $unit[$i] . ' ';
                } elseif ($count > 0 && $count < 10) {
                    $str .= $base[$count] . ' ' . $unit[$i] . ' ';
                }
                $number -= $numeric[$i] * $count;
                $i++;
            }
            $str = preg_replace('/satu puluh (\w+)/i', '\1 belas', $str);
            $str = preg_replace('/satu (ribu|ratus|puluh|belas)/', 'se\1', $str);
            $str = preg_replace('/\s{2,}/', ' ', trim($str));
        }
        return $str;
    }

    public function upload($folder, $file, $model, $field = '', $id = '', $fileName = '')
    {
        $size = ['original', 'xsmall', 'small', 'large'];
        $dimesions = [[], [80, 50], [150, 93], [550, 340]];

        $base64_image = $file['data'];
        list($type, $file_data) = explode(';', $file['data']);
        list(, $extension) = explode('/', $type);
        list(, $file_data) = explode(',', $file_data);

        $uuid =  Str::uuid();

        foreach ($size as $index => $item) {
            $extension = $file['extension'];
            $item = $item . '/';
            $name = $id ? $item . $folder . '/' . $fileName . '_' . $id . '.' . $extension : $item . $folder . '/' . $fileName . '_' . $uuid . '.' . $extension;

            if ($index == 0) {
                $model->update([$field => $name]);
            }

            if ($index == 0 || $extension != 'pdf') {
                Storage::disk('public')->put($name, base64_decode($file_data));
            }

            if ($index != 0 && $extension != 'pdf') {
                $this->createThumbnail(storage_path('app/public/' . $name), $dimesions[$index][0], $dimesions[$index][1]);
            }
        }

        return true;
    }

    public function deleteUpload($url)
    {
        $size = ['original', 'xsmall', 'small', 'large'];

        foreach ($size as $index => $item) {
            Storage::delete(str_replace("original", $item, $url));
        }
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}
