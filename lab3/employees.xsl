<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
  <head>
    <title>Employee List</title>
  </head>
  <body>
    <h1>Employee List</h1>
    <table border="1">
      <tr bgcolor="#9acd32">
        <th>Name</th>
        <th>Email</th>
        <th>Phones</th>
        <th>Address</th>
      </tr>
      <xsl:for-each select="employeeList/employee">
        <tr>
          <td><xsl:value-of select="name"/></td>
          <td><xsl:value-of select="email"/></td>
          <td>
            <xsl:for-each select="phones/phone">
              <xsl:value-of select="concat(., ' ')" />
            </xsl:for-each>
          </td>
          <td>
            <xsl:value-of select="concat(address/street, ', ', address/building, ', ', address/number, ', ', address/region, ', ', address/city, ', ', address/country)" />
          </td>
        </tr>
      </xsl:for-each>
    </table>
  </body>
  </html>
</xsl:template>

</xsl:stylesheet>
