@extends('admin.layouts.admin-app')

@section('content')
<i class="fa-sotdd fa-cart-shopping"></i>
<main>
    <section class="content">


        <div class="page-announce vatdgn-wrapper"><a href="#" data-activates="stdde-out"
                class="button-collapse vatdgn hide-on-large-only"><i class="material-icons">menu</i></a>
            <h1 class="page-announce-text vatdgn">// Brand Approvals </h1>
        </div>
        <div id="posttable" class="container">
            <table class="responsive-table striped hover centered" id="names-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody id="brand__list">

                </tbody>
            </table>
        </div>

    </section>
</main>
@endsection

@section('api_representation')

<script>
const brandUrl = "{{route('admin.brand.index')}}";
const brandList = document.getElementById('brand__list');

fetch(brandUrl)
    .then(response => response.json())
    .then(brands => {
        brands.forEach(brand => {
            const brandTR = createBrandRow(brand);
            brandList.appendChild(brandTR);
        });
    });

function createBrandRow(brand) {
    const brandTR = document.createElement('tr');

    const brandId = document.createElement('td');
    brandId.textContent = brand.id;
    brandTR.appendChild(brandId);

    const brandName = document.createElement('td');
    brandName.textContent = brand.name;
    brandTR.appendChild(brandName);

    const brandButtonTD = document.createElement('td');
    const brandButtonBlock = document.createElement('div');
    brandButtonBlock.className = "btn-toolbar";

    const brandUpdateButton = document.createElement('button');
    brandUpdateButton.className = "btn green";
    brandUpdateButton.innerHTML = '<i class="fa-solid fa-pen"></i>';
    brandUpdateButton.addEventListener('click', () => {
        window.location.href = `{{ route('brand.update', ['id' => 'BRAND_ID']) }}`.replace('BRAND_ID', brand.id);
    });

    const brandDeleteButton = document.createElement('button');
    brandDeleteButton.className = "btn red";
    brandDeleteButton.innerHTML = '<i class="fa-solid fa-cart-shopping"></i>';
    brandDeleteButton.addEventListener('click', () => {
        const brandDeleteUrl = `{{ route('admin.brand.delete', ['id' => 'BRAND_ID']) }}`.replace('BRAND_ID', brand.id);
        fetch(brandDeleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Delete response:', data);
            document.location.reload();
        })
    });

    brandButtonBlock.appendChild(brandUpdateButton);
    brandButtonBlock.appendChild(brandDeleteButton);
    brandButtonTD.appendChild(brandButtonBlock);
    brandTR.appendChild(brandButtonTD);

    return brandTR;
}
</script>

@endsection