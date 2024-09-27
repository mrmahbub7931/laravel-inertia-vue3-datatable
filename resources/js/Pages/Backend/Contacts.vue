<template>
  <div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Contacts List</h1>
    <div class="filter">
      <div class="page_dropdown">
        <p>perpage: </p>
        <select v-model="perPageSelectedOption" id="per_page" @change="handleChange">
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
          <option value="500">500</option>
          <option value="20000">20000</option>
          <option value="50000">50000</option>
          <option value="100000">100000</option>
        </select>
      </div>
      <input type="text" v-model="search" @input="fetchData" placeholder="Search contacts..." />
      <div>
        <label for="start_date">Start Date:</label>
        <input type="date" v-model="startDate" id="start_date">

        <label for="end_date">End Date:</label>
        <input type="date" v-model="endDate" id="end_date">

        <button @click="applyDateFilter" class="filter_btn">Apply Date Filter</button>
      </div>
    </div>
    <table class="table-auto w-full mb-6 border-collapse border border-gray-300">
      <thead>
        <tr>
          <th @click="sortData('id')" class="border px-4 py-2">ID</th>
          <th @click="sortData('name')" class="border px-4 py-2">Name</th>
          <th @click="sortData('email')" class="border px-4 py-2">Email</th>
          <th class="border px-4 py-2">Phone</th>
          <th class="border px-4 py-2">Address</th>
          <th class="border px-4 py-2">Note</th>
          <th class="border px-4 py-2">Created Date</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="contact in data" :key="contact.id">
          <td class="border px-4 py-2">{{ contact.id }}</td>
          <td class="border px-4 py-2">{{ contact.name }}</td>
          <td class="border px-4 py-2">{{ contact.email }}</td>
          <td class="border px-4 py-2">{{ contact.phone }}</td>
          <td class="border px-4 py-2">{{ contact.address }}</td>
          <td class="border px-4 py-2">{{ contact.note }}</td>
          <td class="border px-4 py-2">{{ contact.created_at }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex justify-between">
      <button @click="prevPage" :disabled="page <= 1" class="px-4 py-2 bg-gray-300 rounded">
        Previous
      </button>

      <button @click="nextPage" :disabled="page >= totalPages" class="px-4 py-2 bg-gray-300 rounded">
        Next
      </button>
      <p>Page {{ page }} of {{ totalPages }}</p>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
  setup() {

    const data = ref([]);
    const search = ref('');
    const page = ref(1);
    const totalPages = ref(0);
    const sortBy = ref('id');
    const sortDirection = ref('asc');
    const startDate = ref('');
    const endDate = ref('');
    const perPageSelectedOption = ref('');
    const perPage = ref(25);


    const fetchData = async () => {
      const response = await fetch(`/api/contacts?search=${search.value}&page=${page.value}&sortBy=${sortBy.value}&sortDirection=${sortDirection.value}&perPage=${perPage.value}&start_date=${startDate.value}&end_date=${endDate.value}`);
      const result = await response.json();
      data.value = result.data;
      totalPages.value = result.last_page;
    };
    const handleChange = () => {
      perPage.value = perPageSelectedOption.value
      fetchData();
    }
    const sortData = (column) => {
      sortDirection.value = (sortDirection.value === 'asc') ? 'desc' : 'asc';
      sortBy.value = column;
      fetchData();
    };

    const nextPage = () => {
      if (page.value < totalPages.value) {
        page.value++;
        fetchData();
      }
    };

    const prevPage = () => {
      if (page.value > 1) {
        page.value--;
        fetchData();
      }
    };

    const applyDateFilter = () => {
      page.value = 1;
      fetchData();
    };

    onMounted(fetchData); // Fetch data on component mount


    return {
      data,
      search,
      page,
      totalPages,
      sortData,
      nextPage,
      prevPage,
      fetchData,
      startDate,
      endDate,
      applyDateFilter,
      perPage,
      perPageSelectedOption,
      handleChange
    };
  }
}
</script>
<style scoped>
.page_dropdown {
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.page_dropdown p {
  margin: 0 10px 0 0;
}

.filter {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}

.filter_btn {
  border: 0px;
  background-color: #f52282;
  color: #fff;
  padding: 0.5rem 1rem;
  margin-left: 10px;
}
</style>