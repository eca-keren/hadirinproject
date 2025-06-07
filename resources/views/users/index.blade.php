<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <title>User Management</title>
  <style>
    /* Action buttons styling for mobile */
    @media (max-width: 640px) {
      .action-buttons {
        display: flex;
        flex-direction: row;
        gap: 0.5rem;
        justify-content: flex-end;
      }
      .action-btn {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
      }
      .action-text {
        display: none;
      }
    }

    /* Desktop styles */
    @media (min-width: 641px) {
      .action-btn {
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
      }
      .action-text {
        display: inline;
        margin-left: 0.25rem;
      }
    }

    /* Floating button styles */
    .floating-btn {
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .floating-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 sm:py-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="flex items-center space-x-3 sm:space-x-4">
        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
        </a>
        <h1 class="text-lg sm:text-xl font-bold text-gray-800">Pengolahan Data Anggota</h1>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-3xl mx-auto p-4 sm:p-6">
    <!-- Search Bar -->
    <div class="mb-4 sm:mb-6">
      <form method="GET" action="{{ route('users.index') }}" class="w-full">
       <div class="relative w-full">
  <input
    type="text"
    name="search"
    value="{{ request('search') }}"
    placeholder="Cari Anggota..."
    class="w-full pl-10 pr-4 py-2 text-sm sm:text-base rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
  />
  <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
    <img
  src="https://img.icons8.com/glyph-neue/64/search--v1.png"
  alt="Search Icon"
  class="w-5 h-5 sm:w-6 sm:h-6 md:w-5 md:h-5 lg:w-5 lg:h-5"
/>
  </div>
</div>

      </form>
    </div>

    <!-- User List -->
   <!-- User List Cards -->
<div class="space-y-4">
  @forelse ($users as $user)
    <div class="bg-white rounded-lg shadow p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between hover:shadow-lg transition-shadow">
      
      <div class="flex-1 space-y-1">
        <p class="text-gray-500 text-sm">No: <span class="font-semibold">{{ $user->id }}</span></p>
        <p class="text-gray-900 font-semibold text-lg truncate">Nama Lengkap: {{ $user->name }}</p>
        <p class="text-gray-700 text-sm">Email: {{ $user->email }}</p>
        <p class="text-gray-700 text-sm">Jenis Kelamin: {{ $user->gender }}</p>
        <p class="text-gray-700 text-sm">User ID: {{ $user->user_id }}</p>
      </div>
      
      <div class="mt-4 sm:mt-0 flex gap-2 sm:gap-3 justify-end">
        <a href="{{ route('users.edit', $user->id) }}" 
           class="bg-green-50 text-green-600 hover:bg-green-100 px-3 py-2 rounded-md text-sm flex items-center gap-2 transition"
           title="Edit">
          <i class="fas fa-edit"></i> <span>Edit</span>
        </a>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
          @csrf
          @method('DELETE')
          <button type="submit" 
                  class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-2 rounded-md text-sm flex items-center gap-2 transition"
                  title="Delete">
            <i class="fas fa-trash-alt"></i> <span>Delete</span>
          </button>
        </form>
      </div>
    </div>
  @empty
    <div class="text-center text-gray-500 py-6">
      <i class="fas fa-users-slash text-3xl mb-3 text-gray-300"></i>
      <p class="text-base">No users found</p>
    </div>
  @endforelse
</div>

      
     

  <!-- Floating Add Button -->
  <a href="{{ route('users.create') }}" 
     class="floating-btn fixed bottom-5 right-5 bg-green-600 text-white rounded-full p-4 hover:bg-green-700 transition duration-200"
     title="Add User">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="12" y1="5" x2="12" y2="19"></line>
      <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
    <span class="sr-only">Add User</span>
  </a>
</body>
</html>