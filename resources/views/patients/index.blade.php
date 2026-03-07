<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('asset/css/style_patient.css') }}">
        <link
            href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap"
            rel="stylesheet">
        <title>Dashboard Patients</title>
    </head>
    <body>
        @extends('layouts.sidebar') 
        @section('content')
        <div class="topbar">
            <div class="breadcrumb">
                <a href="{{ route('patients.index') }}">Patients</a>
                <span class="sep">›</span>
            </div>

            <a href="{{ route('patients.create') }}" class="btn-new">
                <svg viewbox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="16" y1="11" x2="22" y2="11"/>
                </svg>
                Nouvel patient
            </a>
        </div>

        <h3>Filtres rapides</h3>

        <!-- 3 CARDS SÉPARÉES -->
        <div class="filters">

            <!-- Card 1 : Total Patients -->
            <div class="stat-card" style="cursor: pointer;" onclick="document.getElementById('patients-list-table').style.display = document.getElementById('patients-list-table').style.display === 'none' ? 'block' : 'none'">
                <div class="card_icon">
                    <svg viewbox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <!-- Removed anchor tag and made the div itself clickable -->
                <div class="card_info">
                    <div class="card_info">
                        <div class="card_value">{{ $totalPatients }}</div>
                        <div class="card_label">Total Patients</div>
                    </div>
                </div>
            </div>

            <!-- Card 2 : Planifiés aujourd'hui -->
            <div class="stat-card">
                <div class="card_icon">
                    <svg viewbox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>
                    </svg>
                </div>
                <div class="card_info">
                    <div class="card_value">{{ $patientsPlannedToday }}</div>
                    <div class="card_label">Planifiés aujourd'hui</div>
                </div>
            </div>

            <!-- Card 3 : Consultés aujourd'hui -->
            <div class="stat-card">
                <div class="card_icon">
                    <svg viewbox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="card_info">
                    <div class="card_value">{{ $patientsConsultedToday }}</div>
                    <div class="card_label">Consultés aujourd'hui</div>
                </div>
            </div>

        </div>

        <!-- LISTE DES PATIENTS -->
        <div id="patients-list-table" class="patients-container" style="display: block;">
            <div class="table-header">
                <h3>Liste de tous les Patients</h3>
                <form action="{{ route('patients.index') }}" method="GET" class="search-form">
                    <input type="text" name="search" id="search-input" class="search-input" placeholder="Rechercher (Nom, CIN...)" value="{{ request('search') }}">
                    <button type="submit" class="btn-search">Chercher</button>
                    @if(request('search'))
                        <a href="{{ route('patients.index') }}" class="btn-search" style="background:var(--text-muted); text-decoration:none; display:flex; align-items:center;">Reset</a>
                    @endif
                </form>
            </div>
            
            <div style="overflow-x: auto;">
                <table class="patients-table">
                    <thead>
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>CIN</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="patients-tbody">
                        @forelse($patients as $patient)
                        <tr>
                            <td style="font-weight: 500; color: var(--text-primary);">{{ $patient->last_name }} {{ $patient->first_name }}</td>
                            <td>{{ $patient->cin ?? 'N/A' }}</td>
                            <td>{{ $patient->email ?? 'N/A' }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('patients.show', $patient->id) }}" class="btn-action view" title="Voir">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
                                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn-action edit" title="Éditer">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer {{ $patient->first_name }} {{ $patient->last_name }} ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Supprimer">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">Aucun patient trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-wrapper">
                {{ $patients->appends(request()->query())->links() }}
            </div>
        </div>

        <style>
            :root {
              --accent:         #3a7d5c;
              --accent-light:   #eaf3ee;
              --accent-mid:     #c4ddd0;
              --accent-glow:    rgba(58,125,92,.15);
              --accent-dark:    #2a6048;
              --text-primary:   #1a2b22;
              --text-secondary: #4a6358;
              --text-muted:     #8aad9c;
              --text-label:     #6b8c7d;
              --border:         #dce8e1;
              --bg-field:       #f4f7f5;
              --ease:           cubic-bezier(.4,0,.2,1);
            }
            
            .patients-container {
                margin-top: 30px;
                background: white;
                padding: 24px;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.03);
                border: 1px solid var(--border);
                transition: height var(--ease);
            }
            
            .table-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                flex-wrap: wrap;
                gap: 15px;
            }
            
            .table-header h3 {
                margin: 0;
                color: var(--text-primary);
                font-size: 1.25rem;
            }
            
            .search-form {
                display: flex;
                gap: 10px;
            }
            
            .search-input {
                padding: 8px 16px;
                border: 1px solid var(--border);
                border-radius: 8px;
                background: var(--bg-field);
                color: var(--text-primary);
                outline: none;
                transition: border-color var(--ease), box-shadow var(--ease);
            }
            
            .search-input:focus {
                border-color: var(--accent);
                box-shadow: 0 0 0 3px var(--accent-glow);
            }
            
            .btn-search {
                padding: 8px 16px;
                background: var(--accent);
                color: white;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: background var(--ease);
                font-weight: 500;
                font-family: inherit;
                font-size: 0.9rem;
            }
            
            .btn-search:hover {
                background: var(--accent-dark);
            }
            
            .patients-table {
                width: 100%;
                text-align: left;
                border-collapse: collapse;
                min-width: 800px;
            }
            
            .patients-table th {
                background-color: var(--bg-field);
                color: var(--text-label);
                font-weight: 600;
                padding: 14px 16px;
                border-bottom: 1px solid var(--border);
                border-top: 1px solid var(--border);
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 0.05em;
            }
            
            .patients-table td {
                padding: 16px;
                border-bottom: 1px solid var(--border);
                color: var(--text-secondary);
                transition: background-color var(--ease);
                vertical-align: middle;
            }
            
            .patients-table tbody tr:hover td {
                background-color: var(--accent-light);
            }
            
            .action-icons {
                display: flex;
                gap: 8px;
                justify-content: flex-end;
            }
            
            .btn-action {
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                border: none;
                background: transparent;
                color: var(--text-muted);
                cursor: pointer;
                transition: all var(--ease);
                text-decoration: none;
            }
            
            .btn-action:hover {
                background: var(--accent-light);
                color: var(--accent);
            }
            
            .btn-action.delete:hover {
                background: #fee2e2;
                color: #ef4444;
            }
            
            .pagination-wrapper {
                margin-top: 24px;
                display: flex;
                justify-content: flex-end;
            }
            
            /* Responsive overrides */
            @media (max-width: 768px) {
                .patients-container {
                    padding: 16px;
                }
                .table-header {
                    flex-direction: column;
                    align-items: flex-start;
                }
                .search-form {
                    width: 100%;
                }
                .search-input {
                    flex: 1;
                }
            }
            
            /* Classes utilitaires pour la pagination Bootstrap 5 (masquer mobile/desktop) */
            nav.d-flex { align-items: center; justify-content: space-between; width: 100%; gap: 15px; margin-top: 10px; }
            .d-none { display: none; }
            .d-flex { display: flex; }
            .justify-content-between { justify-content: space-between; }
            @media (min-width: 576px) {
                .d-sm-none { display: none; }
                .d-sm-flex { display: flex; }
                .align-items-sm-center { align-items: center; }
                .justify-content-sm-between { justify-content: space-between; }
                .flex-sm-fill { flex: 1 1 auto; }
            }
            nav p.small { margin: 0; color: var(--text-muted); font-size: 0.9rem; }

            /* Pagination personnalisée plus jolie */
            nav .pagination {
                display: flex;
                list-style: none;
                padding: 0;
                margin: 0;
                gap: 5px;
            }
            nav .pagination .page-item .page-link {
                padding: 8px 12px;
                border-radius: 6px;
                border: 1px solid var(--border);
                color: var(--accent);
                text-decoration: none;
                transition: all var(--ease);
                background: white;
            }
            nav .pagination .page-item.active .page-link {
                background: var(--accent);
                color: white;
                border-color: var(--accent);
            }
            nav .pagination .page-item:not(.active) .page-link:hover {
                background: var(--accent-light);
            }
            nav .pagination .page-item.disabled .page-link {
                color: var(--text-muted);
                background: var(--bg-field);
            }
        </style>

        @endsection
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search-input');
                const tbody = document.getElementById('patients-tbody');
                
                if(searchInput && tbody) {
                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase();
                        const rows = tbody.querySelectorAll('tr');
                        
                        let hasVisibleRow = false;
                        
                        rows.forEach(row => {
                            // Skip the empty message row
                            if(row.querySelector('td[colspan="5"]')) return;
                            
                            const text = row.textContent.toLowerCase();
                            if(text.includes(query)) {
                                row.style.display = '';
                                hasVisibleRow = true;
                            } else {
                                row.style.display = 'none';
                            }
                        });
                        
                        // Handle "No patient found" message
                        let emptyRow = tbody.querySelector('.empty-message-row');
                        
                        if(!hasVisibleRow) {
                            if(!emptyRow) {
                                emptyRow = document.createElement('tr');
                                emptyRow.className = 'empty-message-row';
                                emptyRow.innerHTML = '<td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">Aucun patient trouvé pour cette recherche.</td>';
                                tbody.appendChild(emptyRow);
                            } else {
                                emptyRow.style.display = '';
                            }
                        } else if(emptyRow) {
                            emptyRow.style.display = 'none';
                        }
                    });
                }
            });
        </script>
    </body>
</html>

