<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobsCollection;
use App\Http\Resources\Job as JobsResources;
use App\Job;
use App\Repositories\BaseJobRepository;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="API", version="0.0.1")
 **/
/**
 *  @OA\Server(
 *      url="http://myjobsearch/api/",
 *      description="L5 Swagger OpenApi Server"
 * )
 */
class JobController extends Controller
{
    /**
     * @var BaseJobRepository
     */
    private $repo;
    public function __construct(BaseJobRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/jobs",
     * @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     )
     */
    public function index()
    {
        return new JobsCollection($this->repo->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/jobs",
     *       @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     )
     */
    public function store(Request $request)
    {
        $job = new Job();
        $job->title = $request->title;
        $job->description = $request->description;
        $job->company_name = $request->company_name;
        $this->repo->save($job);
        return new JobsResources($job);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/jobs/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          description="Job id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     * 
     *     )
     */
    public function show(int $id)
    {
        return new JobsResources($this->repo->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *      path="/jobs/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          description="Job id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     * 
     *     )
     */
    public function update(Request $request, int $id)
    {
        $job = $this->repo->find($id);
        $job->title = $request->has('title') ? $request->title : $job->title;
        $job->description = $request->has('description') ? $request->description : $job->description;
        $job->company_name = $request->has('company_name') ? $request->company_name : $job->company_name;
        $this->repo->save($job);
        return new JobsResources($job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *      path="/jobs/{id}",
     *            @OA\Parameter(
     *          name="id",
     *          description="Job id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     )
     */
    public function destroy(int $id)
    {
        $job = $this->repo->find($id);
        $this->repo->delete($id);
        return new JobsResources($job);
    }
}
