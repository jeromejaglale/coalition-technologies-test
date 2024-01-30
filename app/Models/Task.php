<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'priority'
    ];

    public function update_priority($new_priority) {
    	$old_priority = $this->priority;

		if($new_priority != $old_priority) {
			// update task priority
			$this->priority = $new_priority;
	    	$this->save();

	    	// update other tasks priority
			if($new_priority > $old_priority) {
				$task_list = self::where('priority', '>=', 1)->where('priority', '<=', $new_priority)->where('id', '!=', $this->id)->orderBy('priority')->get();
				$priority = 1;
				foreach ($task_list as $t) {
					$t->priority = $priority;
					$t->save();
					$priority++;
				}
			}
			else {
				$task_list = Task::where('priority', '>=', $new_priority)->where('id', '!=', $this->id)->orderBy('priority')->get();
				$priority = $new_priority + 1;
				foreach ($task_list as $t) {
					$t->priority = $priority;
					$t->save();
					$priority++;
				}
			}
		}
    }
}
