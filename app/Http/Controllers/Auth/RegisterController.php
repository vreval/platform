<?php

namespace App\Http\Controllers\Auth;

use App\Form;
use App\Http\Controllers\Controller;
use App\Project;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $project = Project::factory()->create([
            'owner_id' => $user->id,
            'name' => 'Example Project',
            'description' => 'This is a basic sample project to help you get started and become familiar with all the project building blocks (or components) that are available.\r\n You might want to click through all the predefined components and read their description. They teach you about the overall purpose of each of them.',
        ]);

        $project->pinBy($user);

        $baseline = $project->addScenario([
            'name' => 'Baseline',
            'description' => 'Use Scenarios to replicate your study structure. It\'s is often a good idea to start off collecting some sort of behavioural baseline from your subjects.'
        ]);

        $stressor = $project->addScenario([
            'name' => 'Stressor',
            'description' => 'Here you might want to aggravate the subject to illicit a certain response, which you might want to investigate.'
        ]);

        $recovery = $project->addScenario([
            'name' => 'Recovery',
            'description' => 'Record the recovery period of your subjects to finalize the run.'
        ]);

        $start = $project->addCheckpoint(['name' => 'Start',]);
        $end = $project->addCheckpoint(['name' => 'End',]);
        $st1 = $project->addCheckpoint(['name' => 'Stimulus 1',]);
        $st2 = $project->addCheckpoint(['name' => 'Stimulus 2',]);
        $st3 = $project->addCheckpoint(['name' => 'Stimulus 3',]);
        $tree = $project->addCheckpoint(['name' => 'Tree',]);
        $bench = $project->addCheckpoint(['name' => 'Bench',]);

        $baseline->addCheckpoints(collect([$start, $end]));
        $stressor->addCheckpoints(collect([$start, $st1, $st2, $st3, $end]));
        $recovery->addCheckpoints(collect([$start, $tree, $bench, $end]));

        $form1 = Form::factory()->make(['project_id' => $project->id, 'name' => 'Form 1']);
        $form2 = Form::factory()->make(['project_id' => $project->id, 'name' => 'Form 2']);
        $form3 = Form::factory()->make(['project_id' => $project->id, 'name' => 'Form 3']);

        $project->addForm($form1->attributesToArray());
        $project->addForm($form2->attributesToArray());
        $project->addForm($form3->attributesToArray());

        return $user;
    }
}
