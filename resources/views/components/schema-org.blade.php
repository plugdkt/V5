{{-- Schema.org Global JSON-LD for AEO and GEO (Generative Engine Optimization) --}}
@php
    $isEn = app()->getLocale() === 'en';
    $facultyName = $isEn ? 'School of Medical Sciences, University of Phayao' : 'คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา';
    $facultyDesc = $isEn 
        ? 'School of Medical Sciences, University of Phayao offers undergraduate and graduate programs in Microbiology, Biochemistry and Molecular Biology, and Nutrition and Dietetics.'
        : 'คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา มุ่งสร้างองค์ความรู้และนวัตกรรมทางการแพทย์ จัดการเรียนการสอนสาขาจุลชีววิทยา ชีวเคมีและชีววิทยาโมเลกุล และโภชนาการและการกำหนดอาหาร';
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "EducationalOrganization",
      "@id": "{{ url('/') }}#organization",
      "name": "{{ $facultyName }}",
      "alternateName": [
        "MedSci UP",
        "School of Medical Sciences",
        "คณะวิทยาศาสตร์การแพทย์ มพ."
      ],
      "url": "{{ url('/') }}",
      "logo": {
        "@type": "ImageObject",
        "@id": "{{ url('/') }}#logo",
        "url": "{{ asset('storage/Logo_MedSci_th.webp') }}",
        "caption": "{{ $facultyName }}"
      },
      "image": "{{ asset('storage/Logo_MedSci_th.webp') }}",
      "description": "{{ $facultyDesc }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "19 หมู่ 2 ตำบลแม่กา",
        "addressLocality": "อำเภอเมืองพะเยา",
        "addressRegion": "จังหวัดพะเยา",
        "postalCode": "56000",
        "addressCountry": "TH"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 19.0287,
        "longitude": 99.8967
      },
      "telephone": "+66-54-466-666,3811",
      "email": "medsci@up.ac.th",
      "parentOrganization": {
        "@type": "CollegeOrUniversity",
        "name": "มหาวิทยาลัยพะเยา (University of Phayao)",
        "url": "https://www.up.ac.th"
      },
      "sameAs": [
        "https://www.facebook.com/medsciup",
        "https://www.up.ac.th",
        "https://maps.google.com/?q=19.0287,99.8967"
      ]
    },
    {
      "@type": "WebSite",
      "@id": "{{ url('/') }}#website",
      "url": "{{ url('/') }}",
      "name": "{{ $facultyName }}",
      "description": "{{ $facultyDesc }}",
      "publisher": {
        "@id": "{{ url('/') }}#organization"
      },
      "inLanguage": "{{ $isEn ? 'en-US' : 'th-TH' }}"
    }
  ]
}
</script>
