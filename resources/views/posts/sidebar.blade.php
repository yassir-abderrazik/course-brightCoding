<x-card title="Most post commented" :items="collect($mostCommented)->pluck('title')">
</x-card><br>


<x-card title="Most Active User" :items="collect($activeUser)->pluck('name')">
</x-card><br>


<x-card title="Active User Last Month" :items="collect($activeUser)->pluck('name')">
</x-card><br>