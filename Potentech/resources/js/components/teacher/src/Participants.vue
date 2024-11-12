<template>
    <div class="container mt-5">
        <h1>Teachers List</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="teacher in teachers" :key="teacher.id">
                <td>{{ teacher.name }}</td>
            </tr>
            </tbody>
        </table>
    
        <h1 class="mt-5">Participants List</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Permission</th>
                <th>Points</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="participant in participants" :key="participant.id">
                <td>{{ participant.name }}</td>
                <td>
                <span v-if="participant.permission === true">
                    <i class="fa-solid fa-circle-check text-success"></i> Granted
                </span>
                <span v-else-if="participant.permission === false">
                    <i class="fa-solid fa-circle-xmark text-danger"></i> Denied
                </span>
                <span v-else>Not Set</span>
                </td>
                <td>
                    <div >
                        {{ participant.points }}
                        <button @click="adjustPoints(participant, 1)" class="btn btn-info btn-sm">+</button>
                        <button @click="adjustPoints(participant, -1)" class="btn btn-info btn-sm">-</button>
                    </div>
                </td>
                <td>
                    <button @click="setPermission(participant, true)" class="btn btn-success btn-sm" v-if="participant.permission === null">
                        <i class="fa-solid fa-circle-check"></i> Grant
                    </button>
                    <button @click="setPermission(participant, false)" class="btn btn-danger btn-sm" v-if="participant.permission === null">
                        <i class="fa-solid fa-circle-xmark"></i> Deny
                    </button>
                    <span v-else>
                        <button @click="togglePermission(participant)" class="btn btn-warning btn-sm">
                            {{ checkPermission(participant) ? "Deny" : "Grant" }}
                        </button>
                    </span>
                    <!-- Points adjustment buttons -->
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            teachers: [
                { id: 1, name: 'Mr. Smith', permission: null },
                { id: 2, name: 'Ms. Johnson', permission: null },
                { id: 3, name: 'Mrs. Brown', permission: null },
            ],
            participants: [
                { id: 1, name: 'Alice', permission: null, points: 0 },
                { id: 2, name: 'Bob', permission: null, points: 0 },
                { id: 3, name: 'Charlie', permission: null, points: 0 },
            ],
        };
    },
    methods: {
        setPermission(person, value) {
            person.permission = value;
            alert(`${person.name}'s permission set to ${value ? 'Granted' : 'Denied'}`);
        },
        togglePermission(person) {
            if (person.permission === true) {
                person.permission = false;
                alert(`${person.name}'s permission set to Denied`);
            } else if (person.permission === false) {
                person.permission = true;
                alert(`${person.name}'s permission set to Granted`);
            }
        },
        adjustPoints(person, value) {
            person.points += value;
            if (person.points < 0) person.points = 0;  // Prevent negative points
            alert(`${person.name}'s points are now ${person.points}`);
        },
    },
};
</script>
  
<style>
.btn {
    margin-right: 5px;
}
</style>
