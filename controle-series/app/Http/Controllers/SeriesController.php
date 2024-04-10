<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Autenticador;
use App\Http\Requests\SeriesFormRequest;
// use App\Models\Episode;
// use App\Models\Season;
use App\Models\Series;
// use App\Repositories\EloquentSeriesRepository;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware(Autenticador::class)->except('index');
    }

    public function index(Request $request)
    {
        // return $request->get('id');
        // return $request->url();
        // return $request->method();
        // return response('', 302, ['location' => 'https://google.com']);
        // return redirect('https://google.com');

        // $series = Serie::all();

        // $series = DB::select('SELECT * FROM series;');

        // $series = [
        //     'Punisher',
        //     'Lost',
        //     'Grey\'s Anatomy'
        // ];

        // $html = '<ul>';
        // foreach ($series as $serie) {
        //     $html .= "<li>$serie</li>";
        // }
        // $html .= '</ul>';
        // return $html;
        // return view('listar-series', [
        //     'series' => $series
        // ]);
        // return view('listar-series', compact('series'));
        // return view('listar-series')->with('series', $series);

        $series = Series::all();

        // $series = Serie::query()->orderBy('nome')->get();

        $mensagemSucesso = $request->session()->get('mensagem.sucesso');

        // $request->session()->forget('mensagem.sucesso');

        return view('series.index')
            ->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create(Request $request)
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        // DB::insert('INSERT INTO series (nome) VALUES (?);', [$nomeSerie]);

        // $nomeSerie = $request->nome;
        // $nomeSerie = $request->input('nome');
        // $serie = new Serie();
        // $serie->nome = $nomeSerie;
        // $serie->save();

        // $request->validate([
        //     'nome' => ['required', 'min:3']
        // ]);



        // $serie = Series::create($request->all());
        // for ($i=1; $i <= $request->seasonsQty; $i++) {
        //     $season = $serie->seasons()->create([
        //         'number' => $i,
        //     ]);
        //     for ($j=1; $j <= $request->episodesPerSeason; $j++) {
        //         $season->episodes()->create([
        //             'number' => $j,
        //         ]);
        //     }
        // }

        // $serie = DB::transaction(function() use ($request, &$serie) {
        //     $serie = Series :: create($request->all());
        //     $seasons = [];
        //     for ($i = 1; $i <= $request->seasonsQty; $i++) {
        //         $seasons[] = [
        //             'series_id' => $serie->id,
        //             'number' => $i,
        //         ];
        //     }
        //     Season::insert($seasons);

        //     $episodes = [];
        //     foreach ($serie->seasons as $season) {
        //         for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
        //             $episodes[] = [
        //                 'season_id' => $season->id,
        //                 'number' => $j,
        //             ];
        //         }
        //     }
        //     Episode::insert($episodes);

        //     return $serie;
        // });

        // session()->flash('mensagem.sucesso', "Série {$serie->snome} adicionada com sucesso");

        // DB::beginTransaction();
        // $serie = Series :: create($request->all());
        // $seasons = [];
        // for ($i = 1; $i <= $request->seasonsQty; $i++) {
        //     $seasons[] = [
        //         'series_id' => $serie->id,
        //         'number' => $i,
        //     ];
        // }
        // Season::insert($seasons);

        // $episodes = [];
        // foreach ($serie->seasons as $season) {
        //     for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
        //         $episodes[] = [
        //             'season_id' => $season->id,
        //             'number' => $j,
        //         ];
        //     }
        // }
        // Episode::insert($episodes);
        // DB::commit();

        $serie = $this->repository->add($request);

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
        // return redirect()->route('series.index');
        // return redirect('/series');
    }

    // public function destroy(Request $request)
    public function destroy(Series $series, Request $request)
    {
        // $serie = Serie::find($request->serie);
        // Serie::destroy($request->serie);
        $series->delete();
        // session()->flash('mensagem.sucesso', "Série {$series->snome} removida com sucesso");
        // $request->session()->flash('mensagem.sucesso', 'Série removida com sucesso');
        // $request->session()->put('mensagem.sucesso', 'Série removida com sucesso');
        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");
    }

    public function edit(Series $series, Request $request)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        // $series->nome = $request->nome;
        // $series->save();

        $series->fill($request->all());
        $series->save();

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
    }
}
