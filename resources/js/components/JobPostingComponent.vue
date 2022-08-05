<template>
    <div>
        <table class="table table-hover">
            <thead>
                <th>Job Name</th>
                <th>Job Description</th>
                <th>Vacants</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr v-for="(item, index) in postingList" :key="item.id">
                    <td>{{item.job_name}}</td>
                    <td>{{item.job_description}}</td>
                    <td>{{item.vacants}}</td>
                    <td>
                        <button class="btn btn-secondary" @click="edit(item)">Edit</button>
                        <button class="btn btn-danger" @click="remove(item,index)">Delete</button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Job Name" v-model="form.job_name">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Job Description" v-model="form.job_description">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" class="form-control" placeholder="Vacants" v-model="form.vacants">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <Button class="btn btn-primary" @click="submit">Add</button>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>


<!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Job Name</label>
                    <input type="text" class="form-control" placeholder="Job Name" v-model="formEdit.job_name">
                </div>
                <div class="form-group">
                    <label for="">Job Description</label>
                    <input type="text" class="form-control" placeholder="Job Description" v-model="formEdit.job_description">
                </div>
                <div class="form-group">
                    <label for="">Vacants</label>
                    <input type="number" class="form-control" placeholder="Vacants" v-model="formEdit.vacants">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="save()">Save changes</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['posting'],

    data () {
        return {
            postingList: this.posting,
            form: {
                job_name: null,
                job_description: null,
                vacants: 0
            },
            formEdit: {
                job_name: null,
                job_description: null,
                vacants: 0
            },
            selectedID: null
        }
    },
    methods: {
        submit() {
            const vm = this;
            axios.post('/job_postings', this.form)
            .then(function (response) {
                vm.postingList.push(response.data.data);
                vm.form.job_name = null
                vm.form.job_description = null
                vm.form.vacants = 0
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        remove(item, index) {
            const vm = this;
            axios.delete(`/job_postings/${item.id}`)
            .then(function (response) {
                vm.postingList.splice(index,1);
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        edit(item) {
            console.log(item)
            this.formEdit.job_name = item.job_name;
            this.formEdit.job_description = item.job_description;
            this.formEdit.vacants = item.vacants;
            this.selectedID = item.id
            $('#editModal').modal('show');
        },
        save() {
            const vm = this;
            axios.put(`/job_postings/${vm.selectedID}`, this.formEdit)
            .then(function (response) {
                console.log(response);
                location.reload();
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>