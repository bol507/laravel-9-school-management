import axios from "axios";
import paginationComponent from "./pagination"

export default () => {
    return {
        leaves: [],
        leaveTypes: [],
        leaveStatuses: [],
        selectedEmployee: null,
        selectedLeave: null,
        isLoading: false,
        pagination: paginationComponent(6),
        searchTerm: null,

        init() {
            this.loadLeaves();
        },

        async loadLeaves (page=1){
            try{
                isLoading = true;
                const params = {
                    limit: this.pagination.perPage,
                    page,
                    search: this.searchTerm || undefined,
                };
                const { data } = await axios.get('/ajax/leaves', { params });

                this.leaves = data.leaves;
                this.pagination.initPagination(data.pagination);
            }
            catch (err){
                console.error('Error loading leavs', err)
            }
            finally{
                this.isLoading =false;
            }
        },


        async loadLeave(id){
            try {

                this.isLoading = true;

                const { data } = await axios.get(`/ajax/leaves/${id}`);

                this.selectedLeave = data.leave;

            } catch (err) {
                console.error('Error loading leave ', err);
            } finally {
                this.isLoading = false;
            }
        },

        openLeaveDialog(employee) {
            this.selectedEmployee = employee;
            console.log(employee);
            this.loadLeave(employee.id);
            this.$nextTick(() => {
                this.$refs.leaveDialog.showModal();
            });
        },

        closeLeaveDialog() {
            this.$refs.leaveDialog.close();
            this.selectedEmployee = null;
            this.leaves = [];
        },

        getStatusColor(statusCode) {
            const status = this.leaveStatuses.find(s => s.code === statusCode);
            return status ? status.color : 'gray';
        }
    }
}
