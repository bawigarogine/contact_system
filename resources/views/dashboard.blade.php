<x-user-layout>
    <style>
        .pagination .page-link {
            padding: 0.25rem 0.5rem; /* Adjust padding to make the links smaller */
        }

        .pagination .page-link svg {
            display: none !important;
        }
    </style>
    <div class="container d-flex py-5 justify-content-between">
        <div class="card w-100">
            <div class="card-header">
                <h3 class="mt-3">Contacts</h3>
                <div class="d-flex align-items-center mt-3 justify-content-end">
                    <a href="/create" class="btn btn-outline-primary rounded-0">Add Contact</a>
                    <a href="/contact" class="btn btn-primary rounded-0">Contacts</a>
                    <form method="POST" class="my-auto" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary rounded-0">Logout</button>
                    </form>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <div class="d-flex align-items-center gap-2 w-25">
                        <i class="bi bi-search"></i>
                        <input type="search" class="form-control" id="search" placeholder="Search">
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive" id="table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>COMPANY</th>
                            <th>PHONE</th>
                            <th>EMAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($contacts->count() > 0)
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->company }}</td>
                                    <td>{{ $contact->phone_num }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>
                                        <a href="edit/{{ $contact->id }}" class="text-decoration-none text-dark">Edit</a>
                                        <span class="mx-2">|</span>
                                        <a href="#delete-{{ $contact->id }}" class="text-decoration-none text-dark" data-bs-toggle="modal">Delete</a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="delete-{{ $contact->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form action="delete" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $contact->id }}">
                                                    <h5 class="text-center">Are you sure you want to DELETE?</h5>
                                                    <div class="d-flex align-items-center gap-2 mt-5">
                                                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary w-100">No</button>
                                                        <button type="submit" data-bs-dismiss="modal" class="btn btn-danger w-100">Yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">No record found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div id="pagination">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
    <x-slot:scripts>
        <script>
            $(document).ready(function() {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                function fetchContacts(page, query = '') {
                    $.ajax({
                        type: "POST",
                        url: `search?page=${page}`,
                        data: { _token: CSRF_TOKEN, data: query },
                        cache: false,
                        success: function(data) {
                            var contacts = data.contacts.data;
                            var tbody = $("#table tbody");
                            tbody.empty();
                            if (contacts.length > 0) {
                                contacts.forEach(function(contact) {
                                    tbody.append(
                                        `<tr>
                                            <td>${contact.name}</td>
                                            <td>${contact.company}</td>
                                            <td>${contact.phone_num}</td>
                                            <td>${contact.email}</td>
                                            <td>
                                                <a href="edit/${contact.id}" class="text-decoration-none text-dark">Edit</a>
                                                <span class="mx-2">|</span>
                                                <a href="#delete-${contact.id}" class="text-decoration-none text-dark" data-bs-toggle="modal">Delete</a>
                                            </td>
                                        </tr>`
                                    );
                                });
                            } else {
                                tbody.append(
                                    `<tr>
                                        <td colspan="5">No record found</td>
                                    </tr>`
                                );
                            }
                            $('#pagination').html(data.contacts.links);
                        },
                        error: function() {
                            var tbody = $("#table tbody");
                            tbody.append(
                                `<tr>
                                    <td colspan="5">No record found</td>
                                </tr>`
                            );
                        }
                    });
                }

                $("#search").keyup(function() {
                    var query = $(this).val();
                    fetchContacts(1, query);
                });

                $(document).on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    var query = $('#search').val();
                    fetchContacts(page, query);
                });
            });
        </script>
    </x-slot:scripts>
</x-user-layout>
