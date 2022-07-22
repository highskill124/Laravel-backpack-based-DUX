<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDuxUserRequest;
use App\Http\Requests\UpdateDuxUserRequest;
use App\Repositories\DuxUserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class DuxUserController extends AppBaseController
{
    /** @var DuxUserRepository $duxUsersRepository*/
    private $duxUsersRepository;

    public function __construct(DuxUserRepository $duxUsersRepo)
    {
        $this->duxUsersRepository = $duxUsersRepo;
    }

    /**
     * Display a listing of the duxUser.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $duxUsers = $this->duxUsersRepository->all();

        return view('duxUser.index')
            ->with('duxUsers', $duxUsers);
    }

    /**
     * Show the form for creating a new duxUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('duxUser.create');
    }

    /**
     * Store a newly created duxUser in storage.
     *
     * @param CreateDuxUserRequest $request
     *
     * @return Response
     */
    public function store(CreateDuxUserRequest $request)
    {
        $input = $request->all();

        $duxUsers = $this->duxUsersRepository->create($input);

        Flash::success('Dux Users saved successfully.');

        return redirect(route('duxUsers.index'));
    }

    /**
     * Display the specified duxUser.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $duxUsers = $this->duxUsersRepository->find($id);

        if (empty($duxUsers)) {
            Flash::error('Dux Users not found');

            return redirect(route('duxUsers.index'));
        }

        return view('duxUser.show')->with('duxUsers', $duxUsers);
    }

    /**
     * Show the form for editing the specified duxUser.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $duxUsers = $this->duxUsersRepository->find($id);

        if (empty($duxUsers)) {
            Flash::error('Dux Users not found');

            return redirect(route('duxUsers.index'));
        }

        return view('duxUser.edit')->with('duxUsers', $duxUsers);
    }

    /**
     * Update the specified duxUser in storage.
     *
     * @param int $id
     * @param UpdateDuxUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDuxUserRequest $request)
    {
        $duxUsers = $this->duxUsersRepository->find($id);

        if (empty($duxUsers)) {
            Flash::error('Dux Users not found');

            return redirect(route('duxUsers.index'));
        }

        $duxUsers = $this->duxUsersRepository->update($request->all(), $id);

        Flash::success('Dux Users updated successfully.');

        return redirect(route('duxUsers.index'));
    }

    /**
     * Remove the specified duxUser from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $duxUsers = $this->duxUsersRepository->find($id);

        if (empty($duxUsers)) {
            Flash::error('Dux Users not found');

            return redirect(route('duxUsers.index'));
        }

        $this->duxUsersRepository->delete($id);

        Flash::success('Dux Users deleted successfully.');

        return redirect(route('duxUsers.index'));
    }
}
